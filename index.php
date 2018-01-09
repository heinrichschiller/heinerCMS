<?php

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');

include 'inc/base.inc.php';
include 'inc/public_functions.inc.php';
include 'inc/routes.php';

if(!file_exists($config_ini)) {
    $PHP_SELF = $_SERVER['PHP_SELF'];

    $out = '<p>Wahrscheinlich f&uuml;hren Sie heinerCMS zum erstem mal aus oder es ist ein Fehler aufgetretten.</p>';
    $out .= 'Im Fehlerfall kontaktieren Sie bitte ihren Administrator!</p>';
    $out .= '<p>Wenn Sie heinerCMS zum erstem mal verwerden, klicken Sie jetzt auf</p>';
    $out .= '<a href="$PHP_SELF/../_install_/">Installieren</a>';

    echo $out;

    exit();
}

/* Template einlesen  */
$template = file_get_contents($base['template']);

if (isset($route[$uri]) ) {
    $base['content'] .= $route[$uri]($id);
}

$template = str_replace('<@title@>',$base['title'],$template);
$template = str_replace('<@navigation@>',$base['navigation'],$template);
$template = str_replace('<@content@>',$base['content'],$template);
$template = str_replace('$PHP_SELF',$_SERVER['PHP_SELF'],$template);

echo stripslashes($template);


