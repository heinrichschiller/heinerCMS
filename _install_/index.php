<?php
error_reporting ( - 1 );
ini_set ( 'display_errors', true );

include __DIR__ . '/functions.inc.php';

echo $template = loadTemplate('install');
