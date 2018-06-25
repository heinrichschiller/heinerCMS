<?php

session_start();

if (!file_exists( __DIR__ . '/config/cms-config.php')) {
    header("Location: _installer_/index.php?uri=language&lang=en&db=mysql");
    exit();
}

include __DIR__ . '/config/cms-config.php';

include __DIR__ . '/include/pdo_db_functions.inc.php';
include __DIR__ . '/include/general_functions.inc.php';
include __DIR__ . '/include/public_functions.inc.php';
include __DIR__ . '/include/routes.inc.php';

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');

$content = '';

load_session();

$template = loadTemplate('pub_template');

if (isset($route[$uri]) ) {
    $content .= $route[$uri]($id);
}

$placeholderList = [
    '##placeholder-language##'   => $_SESSION['language'],
    '##placeholder-title##'      => $_SESSION['title'],
    '##placeholder-navigation##' => load_navigation(),
    '##placeholder-content##'    => $content,
    '##placeholder-footer##'     => $_SESSION['footer']
];

$template = strtr($template, $placeholderList);

echo stripslashes($template);