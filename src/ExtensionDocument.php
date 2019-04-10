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

    const ALIAS_SHORT_NAME_NEW = 1; // Short names of new coroutine classes.
    const ALIAS_SHORT_NAME_OLD = 2; // Short names of old coroutine classes.
    const ALIAS_SNAKE_CASE     = 3; // Class names in snake_case. e.g., swoole_timer.

    protected $aliases = [
        self::ALIAS_SHORT_NAME_NEW => [],
        self::ALIAS_SHORT_NAME_OLD => [],
        self::ALIAS_SNAKE_CASE     => [],
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
        $funcs = $this->rf_ext->getFunctions();
        $fdefs = $this->getFunctionsDef(...array_values($funcs));

        file_put_contents(
            $this->dirOutput . '/functions.php',
            "<?php\n/**\n * List of functions from {$this->extensionName} {$this->getVersion()}.\n */\n\n{$fdefs}"
        );

        // Retrieve and save all classes.
        $classes = $this->rf_ext->getClasses();
        // There are three types of class names in Swoole:
        // 1. short name of a class. Short names start with "co\", and they can be found in file output/classes.php.
        // 2. fully qualified name (class name with namespace prefix), e.g., \Swoole\Timer. These classes can be found
        //    under folder output/namespace.
        // 3. snake_case. e.g., swoole_timer. These aliases can be found in file output/classes.php.
        foreach ($classes as $className => $ref) {
            if (strtolower(substr($className, 0, 3)) == 'co\\') {
                $extends = ucwords(str_replace('co\\', 'Swoole\\Coroutine\\', $className), '\\');

                if (class_exists($extends)) {
                    $this->aliases[self::ALIAS_SHORT_NAME_NEW][$className] = $extends;
                } else {
                    $extends = ucwords(str_replace('co\\', 'Swoole\\', $className), '\\');
                    if (class_exists($extends)) {
                        $this->aliases[self::ALIAS_SHORT_NAME_OLD][$className] = $extends;
                    } else {
                        throw new Exception("Unable to detect the original class of alias {$className}.");
                    }
                }
            } elseif (strchr($className, '\\')) {
                $this->exportNamespaceClass($className, $ref);
            } else {
                $this->aliases[self::ALIAS_SNAKE_CASE][$className] = $this->getNamespaceAlias($className);
            }
        }

        $class_alias = "<?php\n\n";
        foreach (array_filter($this->aliases) as $type => $aliases) {
            asort($aliases);
            foreach ($aliases as $alias => $original) {
                $class_alias .= "class_alias({$original}::class, '{$alias}');\n";
            }
            $class_alias .= "\n";
        }

        file_put_contents($this->dirOutput . '/aliases.php', $class_alias);
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
     * @param ReflectionFunction ...$functions
     * @return string
     */
    protected function getFunctionsDef(ReflectionFunction ...$functions): string
    {
        $all = '';
        foreach ($functions as $function) {
            $comment = '';
            $vp = array();
            $params = $function->getParameters();
            if ($params) {
                $comment = "/**\n";
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
            }
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
            throw new Exception("Class $classname should be under namespace \{$this->extensionName} but not.");
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
     * @return string
     */
    protected function getVersion(): string
    {
        return $this->rf_ext->getVersion();
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
