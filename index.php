<?php

session_start();

include __DIR__ . '/inc/general_functions.inc.php';
include __DIR__ . '/inc/public_functions.inc.php';
include __DIR__ . '/inc/routes.php';

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');

$content = '';
$title = 'Heinrich-Schiller.de';
$template_path = 'templates/default/pub_template.tpl.php';

$config_ini = __DIR__ . '/source/configs/config.ini';

load_session();

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

$template = file_get_contents($template_path);

if (isset($route[$uri]) ) {
    $content .= $route[$uri]($id);
}

$template = str_replace('<@title@>',$_SESSION['title'],$template);
$template = str_replace('<@navigation@>',load_public_navigation(),$template);
$template = str_replace('<@content@>',$content,$template);
$template = str_replace('$PHP_SELF',$_SERVER['PHP_SELF'],$template);

echo stripslashes($template);


