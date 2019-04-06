<?php

namespace Swoole\IDEHelper;

use Reflection;
use ReflectionClass;
use ReflectionException;
use ReflectionExtension;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Zend\Code\Generator\ClassGenerator;
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
     * @var string
     */
    protected $version;

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
        $this->version   = $this->rf_ext->getVersion();
    }

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function export(): void
    {
        // Retrieve and save all constants.
        $consts = $this->rf_ext->getConstants();
        $defines = '';
        foreach ($consts as $className => $ref) {
            if (!is_numeric($ref)) {
                $ref = "'$ref'";
            }
            $defines .= "define('$className', $ref);\n";
        }

        if (!is_dir($this->dirOutput)) {
            mkdir($this->dirOutput);
        }

        file_put_contents($this->dirOutput . '/constants.php', "<?php\n" . $defines);

        // Retrieve and save all functions.
        $funcs = $this->rf_ext->getFunctions();
        $fdefs = $this->getFunctionsDef(...array_values($funcs));

        file_put_contents(
            $this->dirOutput . '/functions.php',
            "<?php\n/**\n * List of functions from {$this->extensionName} {$this->version}.\n */\n\n{$fdefs}"
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
                $this->aliases[self::ALIAS_SNAKE_CASE][$className] = self::getNamespaceAlias($className);
            }
        }

        $class_alias = "<?php\n\n";
        foreach (array_filter($this->aliases) as $type => $aliases) {
            asort($aliases);
            foreach ($aliases as $alias => $original) {
                if (self::ALIAS_SNAKE_CASE == $type) {
                    $class_alias .= "class_alias({$original}::class, '{$alias}');\n";
                } else {
                    $class_alias .= "class_alias({$original}::class, {$alias}::class);\n";
                }
            }
            $class_alias .= "\n";
        }

        file_put_contents($this->dirOutput . '/aliases.php', $class_alias);
    }

    /**
     * @param string $comment
     * @return string
     */
    protected static function formatComment(string $comment): string
    {
        $lines = explode("\n", $comment);
        foreach ($lines as &$li) {
            $li = ltrim($li);
            if (isset($li[0]) && $li[0] != '*') {
                $li = self::SPACE_5 . '*' . $li;
            } else {
                $li = self::SPACE_5 . $li;
            }
        }
        return implode("\n", $lines) . "\n";
    }

    /**
     * @param string $className
     * @return string
     */
    protected static function getNamespaceAlias(string $className): string
    {
        if (strtolower($className) == 'co') {
            return "Swoole\\Coroutine";
        } elseif (strtolower($className) == 'chan') {
            return "Swoole\\Coroutine\\Channel";
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
     * @param \ReflectionParameter $parameter
     * @return string|null
     */
    protected static function getDefaultValue(\ReflectionParameter $parameter): ?string
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
                    $default_value = self::getDefaultValue($param);
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
     * @param ReflectionProperty[] $props
     * @return string
     */
    protected function getPropertyDef(array $props): string
    {
        $prop_str = "";
        foreach ($props as $k => $v) {
            $modifiers = implode(' ', Reflection::getModifierNames($v->getModifiers()));
            $prop_str .= self::SPACE_4 . "{$modifiers} $" . $v->name . ";\n";
        }

        return $prop_str;
    }

    /**
     * @param string[] $consts
     * @return string
     */
    protected function getConstantsDef(array $consts): string
    {
        $all = "";
        foreach ($consts as $k => $v) {
            $all .= self::SPACE_4 . "const {$k} = ";
            if (is_int($v)) {
                $all .= "{$v};\n";
            } else {
                $all .= "'{$v}';\n";
            }
        }
        return $all;
    }

    /**
     * @param $classname
     * @param ReflectionMethod[] $methods
     * @return string
     */
    protected function getMethodsDef(string $classname, array $methods): string
    {
        $all = '';
        foreach ($methods as $k => $v) {
            if ($v->isFinal()) {
                continue;
            }

            $method_name = $v->name;

            $vp = array();
            $comment = self::SPACE_4 . "/**\n";

            $config = $this->getConfig($classname, $method_name, self::C_METHOD);
            if (!empty($config['comment'])) {
                $comment .= self::formatComment($config['comment']);
            }

            $params = $v->getParameters();
            if ($params) {
                foreach ($params as $param) {
                    $default_value = self::getDefaultValue($param);
                    $comment .= self::SPACE_5 .
                        "* @param \${$param->name}[" .
                        ($param->isOptional() ? 'optional' : 'required') .
                        "]\n";
                    $vp[] = ($param->isPassedByReference() ? '&' : '') .
                        "\${$param->name}" .
                        ($default_value ? " = {$default_value}" : '');
                }
            }
            if (!isset($config['return'])) {
                $comment .= self::SPACE_5 . "* @return mixed\n";
            } elseif (!empty($config['return'])) {
                $comment .= self::SPACE_5 . "* @return {$config['return']}\n";
            }
            $comment .= self::SPACE_5 . "*/\n";
            $modifiers = implode(
                ' ',
                Reflection::getModifierNames($v->getModifiers())
            );
            $comment .= sprintf(self::SPACE_4 . "%s function %s(%s){}\n\n", $modifiers, $method_name, join(', ', $vp));
            $all .= $comment;
        }

        return $all;
    }

    /**
     * @param string $classname
     * @param ReflectionClass $ref
     * @throws ReflectionException
     */
    protected function exportNamespaceClass(string $classname, ReflectionClass $ref): void
    {
        $ns = explode('\\', $classname);
        if (strtolower($ns[0]) != $this->extensionName) {
            return;
        }

        array_walk($ns, function (&$v, $k) use (&$ns) {
            $v = ucfirst($v);
        });

        $this->writeToPhpFile(
            $this->dirOutput . '/namespace/' . implode('/', array_slice($ns, 1)) . '.php',
            ClassGenerator::fromReflection(new ClassReflection($ref->getName()))->generate()
        );
    }

    /**
     * @param string $classname
     * @param ReflectionClass $ref
     * @return string
     */
    protected function getClassDef(string $classname, ReflectionClass $ref): string
    {
        //获取属性定义
        $props = $this->getPropertyDef($ref->getProperties());

        if ($ref->getParentClass()) {
            $classname .= ' extends \\' . $ref->getParentClass()->name;
        }
        $modifier = 'class';
        if ($ref->isInterface()) {
            $modifier = 'interface';
        }
        //获取常量定义
        $consts = $this->getConstantsDef($ref->getConstants());
        //获取方法定义
        $mdefs = $this->getMethodsDef($classname, $ref->getMethods());
        $class_def = sprintf(
            "%s %s\n{\n%s\n%s\n%s\n}\n",
            $modifier,
            $classname,
            $consts,
            $props,
            $mdefs
        );
        return $class_def;
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
