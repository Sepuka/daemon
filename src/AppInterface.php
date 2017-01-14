<?php

namespace sepuka\daemon;

interface AppInterface
{
    public function run(DaemonInterface $daemon);
}
