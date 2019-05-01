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
  * @source /src/lib/core.php
  * @since 0.12.0
  */
function bootstrap()
{
    $requestItems = parseRequest();

    $controller = $requestItems['controller'];
    $action     = $requestItems['action'];
    $params     = $requestItems['params'];

    $ctrlPath = __DIR__ . "/../modules/$controller/index.php";

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
 * @source /src/lib/core.php
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

/**
 * Get a XML-File for translations in heinerCMS.
 *
 * @param string $language - Name of language
 *
 * @return array
 *
 * @source /installer/src/lib/core.php
 * @since 0.12.0
 */
function getTranslation(string $language) : array
{
    $xmlfile = __DIR__ . "/../locales/$language.xml";

    $xmlString = file_get_contents($xmlfile);
    $xml = simplexml_load_string($xmlString);

    $arr_keys = [];
    $arr_values = [];

    foreach ($xml->children() as $second_gen) {
        foreach ($second_gen->children() as $third_gen) {
            array_push( $arr_keys, '{'.$third_gen->getName().'}');
            array_push( $arr_values, (string)$third_gen);
        }
    }

    return array_combine($arr_keys, $arr_values);
}

/**
 * @source /src/lib/core.php
 * @since 0.9.0
 */
function render(array $templates, array $data = [])
{
    $html = '';

    //$settings = getGeneralSettings();
    $arr_language = getTranslation('de');

    foreach($templates as $key) {
        $html .= renderTemplate($key, $data);
    }

    return strtr($html, $arr_language);
}

/**
 * Render the template.
 *
 * @param string $tplName Name of a template.
 * @param array  $data
 *
 * @source /src/lib/core.php
 * @since 2019.02
 */
function renderTemplate(string $tplName, array $data)
{
    extract($data);

    $requestItems = parseRequest();

    ob_start();

    $ctrl = !empty($requestItems['controller'])
      ? $requestItems['controller']
      : 'index';

    $template = __DIR__ . "/../modules/$ctrl/templates/$tplName";

    include __DIR__ . '/../template/main.phtml';

    $htmlResponse = ob_get_contents();

    ob_clean();

    return $htmlResponse;
}

/**
 * @source /src/lib/core.php
 * @since 0.11.0
 */
function error404()
{
    header('Content-Type:text/html;charset=utf-8');
    header('HTTP/1.0 404 Not Found');
}
