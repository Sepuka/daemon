<?php

namespace sepuka\daemon;

interface CollectorInterface
{
    /**
     * @param DaemonInterface $daemon
     * @return mixed
     */
    public function run(DaemonInterface $daemon);
}
