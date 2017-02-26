<?php

namespace sepuka\daemon;

class Daemon implements DaemonInterface
{
    const LOOP_INTERVAL = 1;

    private $loopEnabled = true;

    public function __construct()
    {
        $this->initSignalHandler();
    }

    private function initSignalHandler()
    {
        pcntl_signal(SIGTERM, [$this, 'signalHandler']);
    }

    public function signalHandler(int $sig)
    {
        switch ($sig) {
            case SIGTERM:
                $this->loopEnabled = false;
                break;
            default:
        }
    }

    public function isLoopEnabled(): bool
    {
        return $this->loopEnabled;
    }

    public function start(CollectorInterface $app)
    {
        $app->run($this);
        $this->loop();
    }

    public function loop(callable $callback = null)
    {
        while ($this->isLoopEnabled()) {
            if (is_callable($callback)) {
                call_user_func($callback);
            }

            sleep(self::LOOP_INTERVAL);
            pcntl_signal_dispatch();
        }
    }
}
