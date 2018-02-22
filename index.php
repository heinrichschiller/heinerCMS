<?php

session_start();

include __DIR__ . '/cms-config.php';

include __DIR__ . '/include/general_functions.inc.php';
include __DIR__ . '/include/public_functions.inc.php';
include __DIR__ . '/include/routes.php';

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');

$content = '';

$template_path = 'templates/default/pub_template.tpl.php';

if (!file_exists('cms-config.php')) {
    header("Location: _installer_/index.php?uri=language"); 
}

load_session();

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


