<?php

/****************************************************************************************
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
 ***************************************************************************************/

/**
 * 
 * 
 * @since 0.2.5
 */
function parseRequest()
{
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 3);
    list($module, $action, $parameter) = explode('/', $path);

    // module? Einbinden eines bestimmten Moduls (eines unterprograms)
    // Module können sein Artikel, Links, Downloads, News, Pages
    // Module liegen in Ordner "modules", die individuell nachgeladen werden können.
    // Module sind von einander getrennt und beeinflussen sich selbst nicht.
    // Neue Module können in Module abgelegt werden, damit diese genutzt werden können.
    require __DIR__ . '/modules/' . $module . '/' . $module . '.php';

    // action => function? Methoden/Funktionen eines Moduls

    // parameter?
}

/**
 * Load a session for heinerCMS.
 * 
 */
function load_session()
{
    $pdo = getPdoConnection();

    $sql = "SELECT `title`, `tagline`, `theme`, `blog_url`, `lang_short`, `footer` 
        FROM `settings` WHERE 1";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    while($settings = $stmt->fetch(PDO::FETCH_OBJ)) {
        $_SESSION['title']    = $settings->title;
        $_SESSION['tagline']  = $settings->tagline;
        $_SESSION['theme']    = $settings->theme;
        $_SESSION['blog-url'] = $settings->blog_url;
        $_SESSION['language'] = $settings->lang_short;
        $_SESSION['footer']   = $settings->footer;
    }
    
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

        $login = loadTemplate('adm_login');
        $template = loadTemplate('adm_login_template');

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
function get_translation(string $language) : array
{
    $xmlfile = __DIR__ . "/../data/locales/$language.xml";

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
 * Loads an HTML template by name and outputs it.
 * 
 * @param string $template - Name of a html-template.
 * 
 * @return string html-template.
 */
function loadTemplate(string $template): string
{
    $split = explode('_', $template);
    $subdirectory = '';

    switch($split[0]) {
        case 'adm' : $subdirectory .= '/admin/';
            break;
        case 'pub' : $subdirectory .= '/public/';
            break;
    }

    $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'default';

    $tplPath = __DIR__ . '/../templates/' . $theme . $subdirectory . $template . '.tpl.php';
    $error = __DIR__ . '/../templates/' . $theme . '/error/error_template.tpl.php';

    if (file_exists($tplPath)) {
        return file_get_contents($tplPath);
    } else {
        return file_get_contents($error);
    }
}
