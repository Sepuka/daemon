<?php

namespace example;

use sepuka\daemon\Daemon;

define('PROJECT_DIR', __DIR__.'/..');

require PROJECT_DIR.'/vendor/autoload.php';

$config = require __DIR__.'/config.php';
$app = new Collector($config);
$daemon = new Daemon();
$daemon->start($app);
