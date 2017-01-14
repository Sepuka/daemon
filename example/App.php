<?php

namespace youapp;

use sepuka\daemon\AppInterface;
use sepuka\daemon\DaemonInterface;

class App implements AppInterface
{
    /** @var array */
    private $config = [];
    /** @var array */
    private $pidRegister = [];
    /** @var DaemonInterface */
    private $daemon;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __destruct()
    {
        foreach ($this->pidRegister as $childPid) {
            posix_kill($childPid, SIGTERM);
        }
    }

    public function run(DaemonInterface $daemon)
    {
        $this->daemon = $daemon;
        $pid = $this->worker();
        $this->registerChild($pid);
    }

    private function worker()
    {
        $this->daemon->loop(function() {});
        return;
    }

    private function registerChild(int $pid)
    {
        $this->pidRegister[] = $pid;
    }
}
