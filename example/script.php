<?php

namespace youapp;

use sepuka\daemon\Daemon;

define('PROJECT_DIR', __DIR__.'/..');

require PROJECT_DIR.'/vendor/autoload.php';

$config = require PROJECT_DIR.'/config/config.php';
$app = new App($config);
$daemon = new Daemon();
$daemon->start($app);
