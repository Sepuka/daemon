<?php

namespace sepuka\daemon;

class Daemon implements DaemonInterface
{
    const LOOP_INTERVAL = 1;

    private $loopEnabled = true;

    /**
     * Daemon constructor.
     */
    public function __construct()
    {
        $this->initSignalHandler();
    }

    private function initSignalHandler()
    {
        pcntl_signal(SIGTERM, [$this, 'signalHandler']);
    }

    /**
     * @param int $sig
     * @return void
     */
    public function signalHandler(int $sig)
    {
        switch ($sig) {
            case SIGTERM:
                $this->loopEnabled = false;
                break;
            default:
        }
    }

    /**
     * @inheritdoc
     */
    public function isLoopEnabled(): bool
    {
        return $this->loopEnabled;
    }

    /**
     * @param CollectorInterface $app
     */
    public function start(CollectorInterface $app)
    {
        $app->run($this);
        $this->loop();
    }

    /**
     * @inheritdoc
     */
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
