<?php

namespace sepuka\daemon;

class Daemon
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

    public function loop(AppInterface $app)
    {
        $app->run();

        while (getenv('LOOP_ENABLED')) {
            sleep(self::LOOP_INTERVAL);
            pcntl_signal_dispatch();
        }
    }
}
