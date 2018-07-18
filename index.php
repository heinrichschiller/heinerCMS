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

session_start();

if (!file_exists( __DIR__ . '/config/db-config.php')) {
    header("Location: _installer_/index.php?uri=language&lang=en&db=mysql");
    exit();
}

include __DIR__ . '/config/cms-config.php';
include __DIR__ . '/config/db-config.php';

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