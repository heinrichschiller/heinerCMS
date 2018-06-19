<?php

session_start();

/**
 * Load a HTML-Template from templates-directory
 * 
 * @param string $template
 * @return string
 */
function loadTemplate(string $template): string
{
    $file = __DIR__ . '/../templates/' . $template . '.tpl.php';

    if (file_exists($file)) {
        return file_get_contents($file);
    }

}

function setLanguage(string $lang)
{
    $_SESSION['lang'] = $lang;
}

function setDatabase(string $db)
{
    $_SESSION['db'] = $db;
}

/**
 * Get a files list of all locales in data/locales directory
 *
 * @param string $lang Choosen language
 * 
 * @return string
 */
function load_locale_options(string $lang) : string
{
    $html = '';

    $locale_dir = __DIR__ . '/../data/locales/';

    $files = scandir($locale_dir);

    for ($i = 2; $i <= count($files) -1; $i++) {
        $xmlFile = $locale_dir . $files[$i];

        $xmlString = file_get_contents($xmlFile);
        $xml = simplexml_load_string($xmlString);

        if ( $xml->attributes()->short == $lang ) {
            $select = ' selected';
        } else {
            $select = '';
        }

        $html .= '<option value="' . $xml->attributes()->short .'"'.$select.'>' . $xml->attributes()->lang . '</option>';
    }

    return $html;
}

function load_database_options(string $db) : string
{
    if ( $_SESSION['db'] == 'mysql' ) {
        $selectMySQL = ' selected';
    } else {
        $selectMySQL = '';
    }

    if ( $_SESSION['db'] == 'sqlite' ) {
        $selectSQLite = ' selected';
    } else {
        $selectSQLite = '';
    }

    $html = '';
    $html .= '<option value="mysql"' . $selectMySQL . '>MySQL</option>';
    $html .= '<option value="sqlite"' . $selectSQLite . '>SQLite</option>';

    return $html;
}

/**
 * Get a translation from translation file.
 * 
 * @param string $language Name of language
 * 
 * @return array
 */
function getTranslation(string $language) : array
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
 * Load start-template
 * 
 * @return string
 */
function load_start() : string
{
    return loadTemplate('start');
}

/**
 * Load language-template
 * 
 * @return string
 */
function load_language() : string
{
    return loadTemplate('language');
}

/**
 * Load licence-template
 * 
 * @return string
 */
function load_licence() : string
{
    return loadTemplate('licence');
}

/**
 * Load conditions-template
 * 
 * @return string
 */
function load_conditions() : string
{
    $serverSoftware = $_SERVER['SERVER_SOFTWARE'];
    $infoList = explode(' ', $serverSoftware);

    $phpVersion = 'PHP/'.phpversion();

    if (version_compare(phpversion(), '7.0', '<')) {
        $phpVersion = 'Gefundene PHP-Version' . phpversion() . 'ist zu niedrig';
    }

    $phpModules = '';

    foreach(get_loaded_extensions() as $item) {
        $phpModules .= $item .',&nbsp;';
    }

    $placeholderList = [
        '##placeholder_webserver##'   => $infoList[0],
        '##placeholder_php_version##' => $phpVersion,
        '##placeholder_php_modules##' => $phpModules,
        '##placeholder_database##'    => 'MySQL'
    ];

    $template = loadTemplate('conditions');

    return strtr($template, $placeholderList);
}

/**
 * Load database-template
 * 
 * @return string
 */
function load_database() : string
{
    $template = loadTemplate('database');

    $db = $_SESSION['db'];

    $dbTemplate = loadTemplate($_SESSION['db'] . '_form');

    $placeholderList = [
        '##placeholder-db-options##' => load_database_options($_SESSION['db']),
        '##placeholder-db-type##'    => $dbTemplate
    ];

    return strtr($template, $placeholderList);
}

/**
 * Load user-template
 * 
 * @return string
 */
function load_user() : string
{
    return loadTemplate('user');
}

/**
 * Load installation-template
 * 
 * @return string
 */
function load_installation() : string
{
    $placeholderList = [];

    if ($_SESSION['db_driver'] == 'mysql') {
        $placeholderList = [
            '##placeholder_database_address##'  => $_SESSION['address'],
            '##placeholder_database_user##'     => $_SESSION['db_user'],
            '##placeholder_database_name##'     => $_SESSION['database'],
            '##placeholder_database_password##' => $_SESSION['db_password']
        ];
    }

    $template = loadTemplate('installation');

    $tplConfig = loadTemplate($_SESSION['db_driver'] . '_config');

    $template = str_replace('##placeholder-config##', $tplConfig, $template);

    return strtr($template, $placeholderList); 
}

/**
 * Load final-template
 * 
 * @return string
 */
function load_final() : string
{
    return loadTemplate('final');
}

/**
 * Create database
 * @param PDO $pdo
 * @param string $database
 * @return bool
 */
function createDatabase(PDO $pdo, string $database) : bool
{
    $sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    try {
        $pdo->exec($sql);
        return true;
    } catch(PDOException $ex) {
        return false;
    }
}

/**
 * Create table articles
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableArticles(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `articles` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `content` LONGTEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            `nextPageId` INT NOT NULL DEFAULT '-1',
            `visibility` TINYINT(4) NOT NULL DEFAULT '0',
            `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE "articles" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `title` TEXT NOT NULL, 
                `content` TEXT NOT NULL, 
                `created_at` TEXT NOT NULL, 
                `updated_at` TEXT, `nextPageId` INTEGER, 
                `visibility` INTEGER NOT NULL, 
                `trash` TEXT NOT NULL )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;

}

/**
 * Create table articles_settings
 *
 * @param PDO $pdo
 * @return bool
 */
function createTableArticlesSettings(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `articles_settings` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `tagline` VARCHAR(100) NOT NULL DEFAULT '',
            `comment` TEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE "articles_settings" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `tagline` TEXT, `comment` TEXT, 
                `created_at` TEXT, 
                `updated_at` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table downloads
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableDownloads(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `downloads` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `comment` TEXT NOT NULL,
            `path` VARCHAR(128) NOT NULL DEFAULT '',
            `filename` VARCHAR(64) NOT NULL DEFAULT '',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            `visibility` TINYINT(4) NOT NULL DEFAULT '0',
            `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE `downloads` ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `title` TEXT NOT NULL, 
                `comment` TEXT, 
                `path` TEXT, 
                `filename` TEXT, 
                `created_at` TEXT, 
                `update_at` TEXT, 
                `visibility` TEXT, 
                `trash` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table downloads_settings
 *
 * @param PDO $pdo
 * @return bool
 */
function createTableDownloadsSettings(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `downloads_settings` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `tagline` VARCHAR(100) NOT NULL DEFAULT '',
            `comment` TEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE "downloads_settings" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `tagline` TEXT, 
                `comment` TEXT, 
                `created_at` TEXT, 
                `update_at` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table links
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableLinks(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `links` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `tagline` VARCHAR(100) NOT NULL DEFAULT '',
            `uri` VARCHAR(255) NOT NULL DEFAULT 'http://',
            `comment` TEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            `visibility` TINYINT(4) NOT NULL DEFAULT '0',
            `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE `links` (
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `title` TEXT NOT NULL,
                `tagline` TEXT,
                `uri` TEXT NOT NULL,
                `comment` TEXT NOT NULL,
                `created_at` TEXT,
                `update_at` TEXT,
                `visibility` TEXT,
                `trash` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table links_settings
 *
 * @param PDO $pdo
 * @return bool
 */
function createTableLinksSettings(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `links_settings` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `tagline` VARCHAR(100) NOT NULL DEFAULT '',
            `comment` TEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,  
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
           $sql = 'CREATE TABLE `links_settings` ( 
               `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
               `tagline` TEXT, 
               `comment` TEXT, 
               `created_at` TEXT, 
               `update_at` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table news
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableNews(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `news` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `message` TEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            `visibility` TINYINT(4) NOT NULL DEFAULT '0',
            `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE "news" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `title` TEXT NOT NULL, `message` TEXT, 
                `created_at` TEXT NOT NULL, 
                `update_at` TEXT, 
                `visibility` TEXT, 
                `trash` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    return false;
}

/**
 * Create table news_settings
 *
 * @param PDO $pdo
 * @return bool
 */
function createTableNewsSettings(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "CREATE TABLE `news_settings` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `tagline` VARCHAR(100) NOT NULL DEFAULT '',
            `comment` TEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE `news_settings` ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `tagline` TEXT, 
                `comment` TEXT, 
                `created_at` TEXT, 
                `update_at` INTEGER )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table users
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableUsers(PDO $pdo, string $dbDriver) : bool
{
    if( checkDatabase($pdo) ) {
        $sql = "CREATE TABLE `users` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `firstname` varchar(255) NOT NULL,
            `lastname` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            `username` VARCHAR(64) NOT NULL,
            `active` ENUM('true','false') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`id`),
            UNIQUE (`username`),
            UNIQUE (`email`)) 
            CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql='CREATE TABLE "users" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `firstname` TEXT NOT NULL, 
                `lastname` TEXT NOT NULL, 
                `email` TEXT NOT NULL, 
                `password` TEXT NOT NULL, 
                `created_at` TEXT, 
                `updated_at` TEXT, 
                `username` TEXT NOT NULL, 
                `active` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table sites
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableSites(PDO $pdo, string $dbDriver) : bool
{
    if ( checkDatabase($pdo) ) {

        $sql = "CREATE TABLE `sites` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `tagline` VARCHAR(140) NOT NULL DEFAULT '',
            `content` LONGTEXT NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` timestamp NULL DEFAULT NULL,
            `visibility` TINYINT(4) NOT NULL DEFAULT '0',
            `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
            PRIMARY KEY (`id`)
            ) CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE `sites` (
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                `title` TEXT NOT NULL,
                `tagline` TEXT,
                `content` TEXT,
                `created_at` TEXT,
                `update_at` TEXT,
                `visibility` TEXT,
                `trash` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Create table settings
 * 
 * @param PDO $pdo
 * @return bool
 */
function createTableSettings(PDO $pdo, string $dbDriver) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = "CREATE TABLE `settings` (
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `tagline` VARCHAR(140) NOT NULL DEFAULT '',
            `theme` VARCHAR(64) NOT NULL DEFAULT '',
            `blog_url` VARCHAR(140) NOT NULL DEFAULT '',
            `lang_short` VARCHAR(3) NOT NULL DEFAULT '',
            `footer` VARCHAR(140) NOT NULL DEFAULT ''
            ) CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        if ($dbDriver == 'sqlite') {
            $sql = 'CREATE TABLE "settings" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `title` TEXT NOT NULL, 
                `tagline` TEXT, 
                `theme` TEXT NOT NULL, 
                `blog_url` TEXT, 
                `lang_short` TEXT NOT NULL, 
                `footer` TEXT NOT NULL )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }
    
    return false;
}

/**
 * Write default configuration into database
 * 
 * @param PDO $pdo
 * @return bool
 */
function writeDefaultConfiguration(PDO $pdo) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = 'INSERT INTO `settings`(`title`, `tagline`, `theme`, `blog_url`, `lang_short`, `footer`)'
            . "VALUES (:title, :tagline, :theme, :blog_url, :lang_short, :footer)";

        $input_parameters = [
            ':title'      => 'heinerCMS',
            ':tagline'    => '',
            ':theme'      => 'default',
            ':blog_url'   => '',
            ':lang_short' => $_SESSION['lang'],
            ':footer'     => 'heinerCMS 2017 - 2018'
        ];

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($input_parameters);

            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Write links configuration into the database.
 * 
 * @param PDO $pdo
 * @return bool
 */
function writeLinksSettingsConfiguration(PDO $pdo) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = "INSERT INTO `links_settings`(`tagline`, `comment`) VALUES ('','');";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Write downloads configuration into database
 *
 * @param PDO $pdo
 * @return bool
 */
function writeDownloadsSettingsConfiguration(PDO $pdo) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = "INSERT INTO `downloads_settings`(`tagline`, `comment`) VALUES ('','');";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Write news configuration into database
 *
 * @param PDO $pdo
 * @return bool
 */
function writeNewsSettingsConfiguration(PDO $pdo) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = "INSERT INTO `news_settings`(`tagline`, `comment`) VALUES ('','');";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Write news configuration into database
 *
 * @param PDO $pdo
 * @return bool
 */
function writeArticlesSettingsConfiguration(PDO $pdo) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = "INSERT INTO `articles_settings`(`tagline`, `comment`) VALUES ('','');";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
    }

    return false;
}

/**
 * Select database by name
 * 
 * @param PDO $pdo
 * @param string $database
 */
function selectDatabase(PDO $pdo, string $database) {
    $sql = "USE `$database`";

    $pdo->exec($sql);
}

/**
 * Check for existed database
 * 
 * @param PDO $pdo
 * @return bool
 */
function checkDatabase(PDO $pdo) : bool
{
    if ($_SESSION['db_driver'] == 'mysql') {
        $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".DB_NAME."'";
    
        foreach ($pdo->query($sql) as $result) {
          return true;
        }
    } else {
        if (file_exists(__DIR__ . '/../../data/sqlite/heinercms.db')) {
            return true;
        }
    }
    return false;
}
