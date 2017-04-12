<?php

error_reporting(-1);
ini_set('display_errors', true);

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');

include 'inc/base.inc.php';
include 'inc/database.inc.php';
include 'inc/functions.inc.php';
include 'inc/routes.php';

/* Template einlesen  */
$template = file_get_contents($base['template']);

if (isset($route[$uri]) ) {
    $base['content'] .= $route[$uri]($id);
}

$template = str_replace('###title###',$base['title'],$template);
$template = str_replace('###navigation###',$base['navigation'],$template);
$template = str_replace('###content###',$base['content'],$template);
$template = str_replace('$PHP_SELF',$_SERVER['PHP_SELF'],$template);

echo stripslashes($template);


