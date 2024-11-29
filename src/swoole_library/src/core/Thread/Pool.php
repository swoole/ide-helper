<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Thread;

use PhpParser\Error;
use PhpParser\ParserFactory;
use Swoole\Thread;

class Pool
{
    private array $threads = [];

    private string $autoloader = '';

    private string $classDefinitionFile = '';

    private string $runnableClass = '';

    private int $threadNum = 0;

    private string $proxyFile;

    private array $arguments = [];

    private object $running;

    private object $queue;

    private array $indexes = [];

    public function __construct(string $runnableClass, int $threadNum)
    {
        if ($threadNum <= 0) {
            throw new \Exception('threadNum must be greater than 0');
        }
        $this->runnableClass = $runnableClass;
        $this->threadNum     = $threadNum;
    }

    public function withArguments(...$arguments): static
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function withAutoloader(string $autoloader): static
    {
        $this->autoloader = $autoloader;
        return $this;
    }

    public function withClassDefinitionFile(string $classDefinitionFile): static
    {
        $this->classDefinitionFile = $classDefinitionFile;
        return $this;
    }

    /**
     * @throws \ReflectionException
     */
    public function start(): void
    {
        if (empty($this->classDefinitionFile) and class_exists($this->runnableClass, false)) {
            $file = (new \ReflectionClass($this->runnableClass))->getFileName();
            if (!$this->isValidPhpFile($file)) {
                throw new \Exception('class definition file must not contain any expressions.');
            }
            $this->classDefinitionFile = $file;
        } elseif ($this->classDefinitionFile) {
            require_once $this->classDefinitionFile;
        }

        if (!class_exists($this->runnableClass)) {
            throw new \Exception("class `{$this->runnableClass}` not found");
        }

        if (!is_subclass_of($this->runnableClass, Runnable::class)) {
            throw new \Exception("class `{$this->runnableClass}` must implements Thread\\Runnable");
        }

        if (empty($this->autoloader)) {
            $include_files = get_included_files();
            foreach ($include_files as $file) {
                if (str_ends_with($file, 'vendor/autoload.php')) {
                    $this->autoloader = $file;
                    break;
                }
            }
        }

        if ($this->autoloader) {
            $this->proxyFile = dirname($this->autoloader) . '/thread_runner.php';
        } else {
            $this->proxyFile = dirname($this->classDefinitionFile) . '/thread_runner.php';
        }

        if (!is_file($this->proxyFile)) {
            $script = '<?php' . PHP_EOL;
            $script .= '$arguments = Swoole\Thread::getArguments();' . PHP_EOL;
            $script .= '$threadId = Swoole\Thread::getId();' . PHP_EOL;
            $script .= '$autoloader = $arguments[0];' . PHP_EOL;
            $script .= '$runnableClass = $arguments[1];' . PHP_EOL;
            $script .= '$queue = $arguments[2];' . PHP_EOL;
            $script .= '$classDefinitionFile = $arguments[3];' . PHP_EOL;
            $script .= '$running = $arguments[4];' . PHP_EOL;
            $script .= '$index = $arguments[5];' . PHP_EOL;
            $script .= '$threadArguments = array_slice($arguments, 6);' . PHP_EOL;
            $script .= 'if ($autoloader) require_once $autoloader;' . PHP_EOL;
            $script .= 'if ($classDefinitionFile) require_once $classDefinitionFile;' . PHP_EOL;
            $script .= '$runnable = new $runnableClass($running, $index);' . PHP_EOL;
            $script .= 'try { $runnable->run($threadArguments); }' . PHP_EOL;
            $script .= 'finally { $queue->push($threadId, Swoole\Thread\Queue::NOTIFY_ONE); }' . PHP_EOL;
            $script .= PHP_EOL;
            file_put_contents($this->proxyFile, $script);
        }

        $this->queue   = new Queue();
        $this->running = new Atomic(1);

        for ($index = 0; $index < $this->threadNum; $index++) {
            $this->createThread($index);
        }

        while ($this->running->get()) {
            $threadId = $this->queue->pop(-1);
            $thread   = $this->threads[$threadId];
            $index    = $this->indexes[$threadId];
            $thread->join();
            unset($this->threads[$threadId], $this->indexes[$threadId]);

            $this->createThread($index);
        }

        foreach ($this->threads as $thread) {
            $thread->join();
        }
    }

    public function shutdown(): void
    {
        $this->running->set(0);
    }

    protected function isValidPhpFile($filePath): bool
    {
        $allowedNodeTypes = [
            \PhpParser\Node\Stmt\Class_::class,
            \PhpParser\Node\Stmt\Const_::class,
            \PhpParser\Node\Stmt\Use_::class,
            \PhpParser\Node\Stmt\Namespace_::class,
            \PhpParser\Node\Stmt\Declare_::class,
        ];

        $parser = (new ParserFactory())->createForNewestSupportedVersion();
        try {
            $code     = file_get_contents($filePath);
            $stmts    = $parser->parse($code);
            $skipLine = -1;
            foreach ($stmts as $stmt) {
                $isAllowed = false;
                foreach ($allowedNodeTypes as $allowedNodeType) {
                    if ($stmt instanceof $allowedNodeType) {
                        $isAllowed = true;
                        break;
                    }
                }
                if (!$isAllowed) {
                    if ($stmt->getLine() == $skipLine) {
                        continue;
                    }
                    return false;
                }
            }
        } catch (Error $error) {
            return false;
        }
        return true;
    }

    protected function createThread($index): void
    {
        $thread = new Thread($this->proxyFile,
            $this->autoloader,
            $this->runnableClass,
            $this->queue,
            $this->classDefinitionFile,
            $this->running,
            $index,
            ...$this->arguments
        );
        $this->indexes[$thread->id] = $index;
        $this->threads[$thread->id] = $thread;
    }
}
