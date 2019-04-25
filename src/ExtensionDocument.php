<?php

namespace Swoole\IDEHelper;

use ReflectionClass;
use ReflectionException;
use ReflectionExtension;
use ReflectionFunction;
use ReflectionParameter;
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Reflection\ClassReflection;

class ExtensionDocument
{
    const C_METHOD = 1;
    const C_PROPERTY = 2;
    const C_CONSTANT = 3;
    const SPACE_4 = '    ';
    const SPACE_5 = self::SPACE_4 . ' ';

    protected $extensionName = 'swoole';

    /**
     * @var string
     */
    protected $language;

    /**
     * @var string
     */
    protected $dirConfig;

    /**
     * @var string
     */
    protected $dirOutput;

    /**
     * @var ReflectionExtension
     */
    protected $rf_ext;

    const ALIAS_SHORT_NAME = 1; // Short names of coroutine classes.
    const ALIAS_SNAKE_CASE = 2; // Class names in snake_case. e.g., swoole_timer.

    protected $aliases = [
        self::ALIAS_SHORT_NAME => [],
        self::ALIAS_SNAKE_CASE => [],
    ];

    /**
     * Methods that don't need to have return type specified.
     */
    const IGNORED_METHODS = [
        '__construct' => null,
        '__destruct'  => null,
    ];

    /**
     * ExtensionDocument constructor.
     *
     * @param string $language
     * @param string $dirOutput
     * @param string $dirConfig
     * @throws Exception
     * @throws ReflectionException
     */
    public function __construct(string $language, string $dirOutput, string $dirConfig)
    {
        if (!extension_loaded($this->extensionName)) {
            throw new Exception("Extension $this->extensionName not enabled or not installed.");
        }

        $this->language  = $language;
        $this->dirOutput = $dirOutput;
        $this->dirConfig = $dirConfig;
        $this->rf_ext    = new ReflectionExtension($this->extensionName);
    }

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function export(): void
    {
        // Retrieve and save all constants.
        $defines = '';
        foreach ($this->rf_ext->getConstants() as $name => $value) {
            $defines .= sprintf("define('%s', %s);\n", $name, (is_numeric($value) ? $value : "'{$value}'"));
        }
        $this->writeToPhpFile($this->dirOutput . '/constants.php', $defines);

        // Retrieve and save all functions.
        $this->writeToPhpFile($this->dirOutput . '/functions.php', $this->getFunctionsDef());

        // Retrieve and save all classes.
        $classes = $this->rf_ext->getClasses();
        // There are three types of class names in Swoole:
        // 1. short name of a class. Short names start with "Co\", and they can be found in file output/aliases.php.
        // 2. fully qualified name (class name with namespace prefix), e.g., \Swoole\Timer. These classes can be found
        //    under folder output/namespace.
        // 3. snake_case. e.g., swoole_timer. These aliases can be found in file output/aliases.php.
        foreach ($classes as $className => $ref) {
            if (strtolower(substr($className, 0, 3)) == 'co\\') {
                $className = str_replace('Swoole\\Coroutine', 'Co', $ref->getName());
                $this->aliases[self::ALIAS_SHORT_NAME][$className] = $ref->getName();
            } elseif (strchr($className, '\\')) {
                $this->exportNamespaceClass($className, $ref);
            } else {
                $this->aliases[self::ALIAS_SNAKE_CASE][$className] = $this->getNamespaceAlias($className);
            }
        }

        $class_alias = '';
        foreach (array_filter($this->aliases) as $type => $aliases) {
            if (!empty($class_alias)) {
                $class_alias .= "\n";
            }
            asort($aliases);
            foreach ($aliases as $alias => $original) {
                $class_alias .= "class_alias({$original}::class, {$alias}::class);\n";
            }
        }
        $this->writeToPhpFile($this->dirOutput . '/aliases.php', $class_alias);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->rf_ext->getVersion();
    }

    /**
     * @param string $className
     * @return string
     */
    protected function getNamespaceAlias(string $className): string
    {
        if (strcasecmp($className, 'co') === 0) {
            return Coroutine::class;
        } elseif (strcasecmp($className, 'chan') === 0) {
            return Channel::class;
        } else {
            return str_replace('_', '\\', ucwords($className, '_'));
        }
    }

    /**
     * @param string $class
     * @param string $name
     * @param string $type
     * @return array
     */
    protected function getConfig(string $class, string $name, string $type): array
    {
        switch ($type) {
            case self::C_CONSTANT:
                $dir = 'constant';
                break;
            case self::C_METHOD:
                $dir = 'method';
                break;
            case self::C_PROPERTY:
                $dir = 'property';
                break;
            default:
                return false;
        }
        $file = $this->dirConfig . '/' . $this->language . '/' . strtolower($class) . '/' . $dir . '/' . $name . '.php';
        if (is_file($file)) {
            return include $file;
        } else {
            return array();
        }
    }

    /**
     * @param ReflectionParameter $parameter
     * @return string|null
     */
    protected function getDefaultValue(ReflectionParameter $parameter): ?string
    {
        try {
            $default_value = $parameter->getDefaultValue();
            if ($default_value === []) {
                $default_value = '[]';
            } elseif ($default_value === null) {
                $default_value = 'null';
            } elseif (is_bool($default_value)) {
                $default_value = $default_value ? 'true' : 'false';
            } else {
                $default_value = var_export($default_value, true);
            }
        } catch (\Throwable $e) {
            if ($parameter->isOptional()) {
                $default_value = 'null';
            } else {
                $default_value = null;
            }
        }
        return $default_value;
    }

    /**
     * @return string
     */
    protected function getFunctionsDef(): string
    {
        $all = '';
        foreach ($this->rf_ext->getFunctions() as $function) {
            $vp = array();
            $comment = "/**\n";
            $params = $function->getParameters();
            foreach ($params as $param) {
                $default_value = $this->getDefaultValue($param);
                $comment .= " * @param \${$param->name}[" .
                    ($param->isOptional() ? 'optional' : 'required') .
                    "]\n";
                $vp[] = ($param->isPassedByReference() ? '&' : '') .
                    "\${$param->name}" .
                    ($default_value ? " = {$default_value}" : '');
            }
            $comment .= " * @return mixed\n";
            $comment .= " */\n";
            $comment .= sprintf("function %s(%s){}\n\n", $function->getName(), join(', ', $vp));
            $all .= $comment;
        }

        return $all;
    }

    /**
     * @param string $classname
     * @param ReflectionClass $ref
     * @throws Exception
     * @throws ReflectionException
     */
    protected function exportNamespaceClass(string $classname, ReflectionClass $ref): void
    {
        $ns = explode('\\', $classname);
        if (strcasecmp($ns[0], $this->extensionName) !== 0) {
            throw new Exception("Class $classname should be under namespace \\{$this->extensionName} but not.");
        }

        $class = ClassGenerator::fromReflection(new ClassReflection($ref->getName()));
        foreach ($class->getMethods() as $method) {
            if ((null === $method->getReturnType()) && !array_key_exists($method->getName(), self::IGNORED_METHODS)) {
                $method->setDocBlock(
                    DocBlockGenerator::fromArray(
                        [
                            'shortDescription' => null,
                            'longDescription'  => null,
                            'tags'             => [
                                new ReturnTag(
                                    [
                                        'datatype' => 'mixed',
                                    ]
                                ),
                            ],
                        ]
                    )
                );
            }
        }

        $this->writeToPhpFile(
            $this->dirOutput . '/namespace/' . implode('/', array_slice($ns, 1)) . '.php',
            $class->generate()
        );
    }

    /**
     * @param string $path
     * @param string $content
     * @return ExtensionDocument
     */
    protected function writeToPhpFile(string $path, string $content): self
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($path, "<?php\n\n" . $content);

        return $this;
    }
}
