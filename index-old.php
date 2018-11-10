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

include __DIR__ . '/configs/cms-config.php';
include CONFIG_PATH . 'db-config.php';
include INCLUDE_PATH . 'general_functions.inc.php';

if (DEBUG_MODE) {
    session_start();
    error_reporting(-1);
    ini_set('display_errors', true);
}

if (!checkSystem()) {
    header("Location: _installer_/index.php?uri=language&lang=en&db=mysql");
    exit();
}

include INCLUDE_PATH . DB_DRIVER . '_db_functions.inc.php';
include INCLUDE_PATH . 'public_functions.inc.php';
include __DIR__ . '/routes/pub_routes.inc.php';

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');
parseRequest();
$content = '';

$template = getTemplate('pub_template');

if (isset($route[$uri]) ) {
    $content .= $route[$uri]($id);
}

$settings = getGeneralSettings();

$placeholderList = [
    '##placeholder-language##'   => $settings['lang_short'],
    '##placeholder-title##'      => $settings['title'],
    '##placeholder-navigation##' => load_navigation(),
    '##placeholder-content##'    => $content,
    '##placeholder-footer##'     => $settings['footer']
];

$template = strtr($template, $placeholderList);

echo stripslashes($template);