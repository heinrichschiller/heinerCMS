<?php

require __DIR__ . '/routes.php';
require __DIR__ . '/include/functions.inc.php';

$uri = filter_input ( INPUT_GET, 'uri' );

$template = loadTemplate('main_template');

if(isset($route[$uri])) {
    $content = $route[$uri]();
} else {
    $content = '';
}

$placeholderList = [
    '##placeholder_title##' => 'heinerCMS-Installation',
    '##placeholder_content##' => $content
];

$template = strtr($template, $placeholderList);

echo stripslashes($template);