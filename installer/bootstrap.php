<?php

include __DIR__ . '/src/autoloader.php';

if (!defined('ABS_PATH')) {
    define('ABS_PATH', __DIR__ . '/');
}

$bootstrap = new Bootstrap();
$bootstrap->run();
