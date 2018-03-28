<?php

/**
 */
function load_session()
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `title`, `tagline`, `theme`, `blog_url`, `lang_short`, `footer` FROM `settings` WHERE 1";
    
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
 * Get a translation.
 * 
 * @param string $language Name of language
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
    $arr_language = [];
    
    foreach ($xml->children() as $second_gen) {
        foreach ($second_gen->children() as $third_gen) {
            array_push( $arr_keys, '{'.$third_gen->getName().'}');
            array_push( $arr_values, (string)$third_gen);
        }
    }
    
    return array_combine($arr_keys, $arr_values);
}

/**
 * Database adapter for MySQL
 *
 * @return PDO
 */
function getPdoDB()
{   
    try {
        
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        
        return $pdo;
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
}

/**
 *
 * @param string $sql
 * @param array $params
 * @return array
 */
function pdo_select(string $sql, array $params) : array
{
    $pdo = getPdoDB();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        if (!empty($params)) {
            $stmt->execute( [$params[0] ]);
        } else {
            $stmt->execute();
        }
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetch();
}

/**
 *
 * @param string $sql
 * @param array $params
 */
function pdo_query(string $sql, array $params)
{
    $pdo = getPdoDB();
}

/**
 *
 * @param string $template
 * @return string
 */
function loadTemplate(string $template): string
{
    $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'default';
    
    $file = __DIR__ . '/../templates/' . $theme . '/' . $template . '.tpl.php';
    $error = __DIR__ . '/../templates/' . $theme . '/error_template.tpl.php';
    
    if (file_exists($file)) {
        return file_get_contents($file);
    }
    
    return file_get_contents($error);
}
