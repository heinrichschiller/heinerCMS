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
 * @filesource /src/lib/heinerCMS.php
 * @since 0.9.0
 */
function heinerCMS()
{
    $requestItems = parseRequest();

    $controller = $requestItems['controller'];
    $action     = $requestItems['action'];
    $params     = $requestItems['params'];

    $modulesPath = ABS_PATH . "src/modules/$controller/index.php";

    if(file_exists($modulesPath)) {
        include_once $modulesPath;
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
 * @filesource /src/lib/heinerCMS.php
 * @since 0.9.0
 */
function parseRequest(): array
{
    $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    $url = filterSanitizeUrl($url);
    $urlItems = explode('/', $url, 3);

    $controller = !empty($urlItems[0]) ? $urlItems[0] : 'public';
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
 * @filesource /src/lib/heinerCMS.php
 */
function isPost()
{
    if(!empty($_POST)) {
        return true;
    }

    return false;
}

/**
 * @filesource /src/lib/heinerCMS.php
 */
function isGet()
{
    if(!empty($_GET)) {
        return true;
    }

    return false;
}

/**
 * @filesource /src/lib/heinerCMS.php
 */
function isFile()
{
    if(!empty($_FILE)) {
        return true;
    }

    return false;
}

/**
 * Get a XML-File for translations in heinerCMS.
 *
 * @param string $language - Name of language
 *
 * @return array
 *
 * @filesource /src/lib/heinerCMS.php
 */
function getTranslation(string $language) : array
{
    $xmlfile = ABS_PATH . "src/locales/$language.xml";

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
 * @filesource /src/lib/heinerCMS.php
 */
function checkSystem()
{
    if (version_compare(phpversion(), '7.0', '<')) {
        return false;
    }

    if (!defined('DB_DRIVER') || !defined('DB_NAME')) {
        return false;
    }

    return true;
}

/**
 * @filesource /src/lib/heinerCMS.php
 */
function render(array $templates, array $data = [])
{
    $html = '';

    $settings = getGeneralSettings();
    $arr_language = getTranslation($settings['lang_short']);

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
 * @filesource /src/lib/heinerCMS.php
 * @since 2019.02
 */
function renderTemplate(string $tplName, array $data)
{
    $config = include ABS_PATH . 'src/configs/default.php';

    extract($data);
    extract(array('entry' => countEntries()));
    extract(array('settings' => getGeneralSettings()));

    $requestItems = parseRequest();

    if($requestItems['action'] == 'goodbye' || $requestItems['action'] == 'login') {
        $navbar = '';
    } elseif (empty($requestItems['controller']) || $requestItems['controller'] == 'public') {
        $navbar = 'public_navigation.phtml';
    } else {
        $navbar = 'admin_navigation.phtml';
    }

    ob_start();

    if (!empty($navbar)) {
        $nav = ABS_PATH . "src/templates/$navbar";
    }

    $module = !empty($requestItems['controller']) ? $requestItems['controller'] : 'public';
    $template = ABS_PATH . "src/modules/$module/templates/$tplName";

    include ABS_PATH . 'src/templates/main.phtml';

    $htmlResponse = ob_get_contents();

    ob_clean();

    return $htmlResponse;
}

/**
 * @filesource /src/lib/heinerCMS.php
 */
function getCurrentDatetime()
{
    return strftime('%d.%m.%Y %H:%M', time());
}

/**
 * @filesource /src/lib/heinerCMS.php
 */
function error404()
{
    header('Content-Type:text/html;charset=utf-8');
    header('HTTP/1.0 404 Not Found');
}
