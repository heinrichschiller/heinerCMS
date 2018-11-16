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

/**
 *
 * General functions for heinerCMS.
 *
 * This file contains:
 *
 * * Comment here
 * * Comment here
 *
 * @author: Heinrich Schiller
 * @date: 2017-06-09
 * @licence: MIT
 *
 */

function bootstrap()
{
    $requestItems = parseRequest();
    
    $controller = !empty($requestItems['controller']) ? $requestItems['controller'] : 'public';

    $action = !empty($requestItems['action']) ? $requestItems['action'] : 'index';
    
    include_once SRC_PATH . "$controller/$controller.php";
    
    // parameter?
    $paramItems = !empty($requestItems['params']) ? $requestItems['params'] : array();
    @$params = explode('/', $paramItems);
    
    // action => function? Methoden/Funktionen eines Moduls
    if (isset($action)) {
        $action = sprintf("%sAction", strtolower($action));
        echo $action($params);
    }
}

/**
 * 
 * 
 * @since 0.9.0
 */
function parseRequest()
{
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $item = explode('/', $path, 3);

    $requestItems = [
        'controller' => $item[0],
        'action' => @$item[1],
        'params' => @$item[2]
    ];
    
    return $requestItems;
}

/**
 * Load a session for heinerCMS.
 * @deprecated
 */
function load_session()
{
    $settings = getGeneralSettings();
    
    $_SESSION['title']    = $settings['title'];
    $_SESSION['tagline']  = $settings['tagline'];
    $_SESSION['theme']    = $settings['theme'];
    $_SESSION['darkmode'] = $settings['darkmode'];
    $_SESSION['blog-url'] = $settings['blog_url'];
    $_SESSION['language'] = $settings['lang_short'];
    $_SESSION['footer']   = $settings['footer'];  
}

/**
 * Checks if a login has taken place.
 * 
 * @return boolean
 */
function is_logged_in() {

    $authenticated = isset($_SESSION['authenticated']) ? true : false;

    load_session();

    /* User angemeldet? */
    if ($authenticated) {
        return true;
    } else {

        $login = getTemplate('adm_login');
        $template = getTemplate('adm_login_template');

        $template = str_replace ( '##placeholder-title##', $_SESSION['title'], $template );
        $template = str_replace ( '##placeholder-form-signin##', $login, $template );

        echo stripslashes ( $template );

        return false;
    }
}

/**
 * 
 */
function destroySession()
{
    /* Wert setzen */
    $_SESSION ['authenticated'] = false;
    $_SESSION ['username'] = '';
    $_SESSION ['user_id'] = '';
    
    /* Session beenden */
    session_destroy ();
    
    /* Umleitung */
    header ( 'Location: index.php' );
}

/**
 * Get a XML-File for translations in heinerCMS.
 * 
 * @param string $language - Name of language
 * 
 * @return array
 */
function getTranslation(string $language) : array
{
    $xmlfile = LOCALES_PATH . "$language.xml";

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
 * Get an HTML template by name and outputs it.
 * 
 * @param string $template - Name of a html-template.
 * 
 * @return string html-template.
 */
function getTemplate(string $template): string
{
    $module = parseRequest();

    $file = __DIR__ . "/../modules/$module[0]/template/$template";

    if (file_exists($file)) {
        return file_get_contents($file);
    }

    return 'No template found.';
}

function getMasterTemplate(string $template): string
{
    $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'default';
    
    $file = SRC_PATH . "/templates/$theme/$template";
    
    if (file_exists($file)) {
        return file_get_contents($file);
    }
    
    //return 'No template found.';
}

function checkSystem()
{
    if (!defined('DB_DRIVER') && !defined('DB_NAME')) {
        return false;
    }

    return true;
}

function render(array $templates, array $data = [])
{
    $module = parseRequest();
    
    $module = !empty($module['controller']) ? $module['controller'] : 'public';
    $navbar = ($module == 'public') ? 'public_navigation.phtml' : 'admin_navigation.phtml';

    $html = '';

    $html .= getMasterTemplate('header.phtml');
    $html .= getMasterTemplate($navbar);

    foreach($templates as $key) {
        $html .= renderTemplate($key, $data);
    }
    
    $html .= getMasterTemplate('footer.phtml');

    //$arr_language = get_translation('de');
    
    //return strtr($html, $arr_language);
    return $html;
}

function renderTemplate(string $template, array $data)
{
    $module = parseRequest();

    $module = !empty($module['controller']) ? $module['controller'] : 'public';

    $tmpltFile = __DIR__ . "/../$module/template/$template";

    extract($data);

    ob_start();

    include $tmpltFile;
    
    $htmlResponse = ob_get_contents();
    
    ob_end_clean();
    
    return $htmlResponse;
}


