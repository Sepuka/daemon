<?php
namespace sepuka\daemon;

interface DaemonInterface
{
    public function loop(callable $callback = null);
}
