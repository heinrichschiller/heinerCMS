<?php

require __DIR__ . '/routes.php';
require __DIR__ . '/include/functions.inc.php';

$uri = filter_input (INPUT_GET, 'uri' );
$lang = filter_input(INPUT_GET, 'lang');
$db = filter_input(INPUT_GET, 'db');

setDatabase($db);
setLanguage($lang);

$template = loadTemplate('main_template');

if(isset($route[$uri])) {
    $content = $route[$uri]();
} else {
    $content = '';
}

/* render mainpage */
$placeholderList = [
    '##placeholder-language##' => $lang,
    '##placeholder-title##'    => 'heinerCMS-Installation',
    '##placeholder-content##'  => $content
];

$template = strtr($template, $placeholderList);

/* render content */
$contentPlaceholderList = [
    '##placeholder-db##'             => $db,
    '##placeholder-lang##'           => $lang,
    '##placeholder-locale-options##' => load_locale_options($lang)
];

$template = strtr($template, $contentPlaceholderList);

/* translation */
$languageList = getTranslation($lang);
$template = strtr($template, $languageList);

echo stripslashes($template);
