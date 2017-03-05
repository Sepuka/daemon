<?php

namespace sepuka\daemon;

interface DaemonInterface
{
    /**
     * @param callable|null $callback
     * @return mixed
     */
    public function loop(callable $callback = null);

    /**
     * @return bool
     */
    public function isLoopEnabled(): bool;
}
