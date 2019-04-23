<?php

/**
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * MIT License
 *
 * Copyright (c) 2017 - 2019 Heinrich Schiller
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

/**
 *
 * @since 0.12.0
 */
function bootstrap()
{
    $requestItems = parseRequest();

    $controller = $requestItems['controller'];
    $action     = $requestItems['action'];
    $params     = $requestItems['params'];

    $ctrlPath = __DIR__ . "/../controller/$controller/index.php";

    if(file_exists($ctrlPath)) {
        include_once $ctrlPath;
    } else {
        error404();
    }

    if (isset($action)) {
        $action = sprintf("%sAction", strtolower($action));

        if(function_exists($action)) {
            echo $action($params);
        } else {
            error404();
        }
    }
}

/**
 *
 *
 * @since 0.12.0
 */
function parseRequest(): array
{
    $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    $url = filterSanitizeUrl($url);
    $urlItems = explode('/', $url, 3);

    $controller = !empty($urlItems[0]) ? $urlItems[0] : 'install';
    $action     = !empty($urlItems[1]) ? $urlItems[1] : 'index';
    $params     = !empty($urlItems[2]) ? $urlItems[2] : array();

    if(!empty($params)) {
        $params = explode('/', $params);
    }

    $requestItems = [
        'controller' => $controller,
        'action'     => $action,
        'params'     => $params
    ];

    return $requestItems;
}

function error404()
{
    header('Content-Type:text/html;charset=utf-8');
    header('HTTP/1.0 404 Not Found');
}
