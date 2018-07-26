<?php
/**
 * This is the main web entry point for heinerCMS.
 *
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * MIT License
 *
 * Copyright (c) 2017 - 2018 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
