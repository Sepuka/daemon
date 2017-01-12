<?php

namespace youapp;

use sepuka\daemon\AppInterface;

class App implements AppInterface
{
    /** @var array */
    private $config = [];
    /** @var array */
    private $childPids = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __destruct()
    {
        foreach ($this->childPids as $childPid) {
            posix_kill($childPid, SIGTERM);
        }
    }

    public function run()
    {
        $pid = $this->worker();
        $this->registerChild($pid);
    }

    private function worker()
    {
        return;
    }

    private function registerChild(int $pid)
    {
        $this->childPids[] = $pid;
    }
}
