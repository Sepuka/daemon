<?php

namespace sepuka\daemon;

interface CollectorInterface
{
    public function run(DaemonInterface $daemon);
}
