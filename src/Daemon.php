<?php

namespace sepuka\daemon;

class Daemon implements DaemonInterface
{
    const LOOP_INTERVAL = 1;

    public function __construct()
    {
        putenv('LOOP_ENABLED=1');
        pcntl_signal(SIGTERM, [$this, 'signalHandler']);
    }

    public function signalHandler(int $sig)
    {
        switch ($sig) {
            case SIGTERM:
                putenv('LOOP_ENABLED=0');
                break;
            default:
        }
    }

    public function start(AppInterface $app)
    {
        $app->run($this);
        $this->loop();
    }

    public function loop(callable $callback = null)
    {
        while (getenv('LOOP_ENABLED')) {
            if (is_callable($callback)) {
                call_user_func($callback);
            }

            sleep(self::LOOP_INTERVAL);
            pcntl_signal_dispatch();
        }
    }
}
