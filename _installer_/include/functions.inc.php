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

        $html .= '<option value="' . 
            $xml->attributes()->short 
        .'"'.$select.'>' 
            . $xml->attributes()->lang 
        . '</option>';
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
function getDBConfiguration() : string
{
    $filename = __DIR__ . '/../templates/' . $_SESSION['db_driver'] . '-config.txt';
    
    if ($_SESSION['db_driver'] == 'mysql') {
        $placeholderList = [
            '##placeholder_database_address##'  => $_SESSION['address'],
            '##placeholder_database_user##'     => $_SESSION['db_user'],
            '##placeholder_database_name##'     => $_SESSION['database'],
            '##placeholder_database_password##' => $_SESSION['db_password']
        ];
        
        $file = file_get_contents($filename);
        
        $result = strtr($file, $placeholderList);
    } else {
        $result = file_get_contents($filename);
    }

    return $result;
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
    $sql = "
    CREATE DATABASE IF NOT EXISTS `$database` 
        CHARSET=utf8 
        COLLATE=utf8_unicode_ci;
    ";

    try {
        $pdo->exec($sql);
        return true;
    } catch(PDOException $ex) {
        return false;
    }
}

/**
 * Create table contents
 *
 * @param PDO $pdo
 * @return bool
 * 
 * @since 0.8.0
 */
function createTableContents(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "
        CREATE TABLE `contents` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(64) NOT NULL DEFAULT '',
            `tagline` VARCHAR(200) NOT NULL DEFAULT '',
            `text` LONGTEXT DEFAULT NULL,
            `content_type` VARCHAR(10) NOT NULL DEFAULT '',
            `next_page_id` INT NOT NULL DEFAULT '-1',
            `path` VARCHAR(128) NOT NULL DEFAULT '',
            `filename` VARCHAR(64) NOT NULL DEFAULT '',
            `uri` VARCHAR(255) NOT NULL DEFAULT 'http://',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            `visibility` ENUM('true','false') NOT NULL DEFAULT 'false',
            `flag` VARCHAR(10) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`))
            CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        
        if($dbDriver=='sqlite') {
            $sql = "
            CREATE TABLE `contents` (
            	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            	`title` TEXT NOT NULL,
            	`tagline` TEXT,
            	`text` TEXT NOT NULL,
            	`content_type` TEXT NOT NULL,
            	`next_page_id` INTEGER,
            	`path` TEXT,
            	`filename` TEXT,
            	`uri` TEXT,
            	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            	`updated_at` DATETIME,
            	`visibility` TEXT NOT NULL,
            	`flag` TEXT);
            ";
        }
        
        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
}

/**
 * Create table contents_settings
 *
 * @param PDO $pdo
 * @return bool
 * 
 * @since 0.8.0
 */
function createTableContentsSettings(PDO $pdo, string $dbDriver) : bool
{
    if(checkDatabase($pdo)) {
        $sql = "
        CREATE TABLE `contents_settings` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `content_type` VARCHAR(100) NOT NULL DEFAULT '',
            `tagline` VARCHAR(100) NOT NULL DEFAULT '',
            `text` TEXT NOT NULL,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `update_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`))
            CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        
        if($dbDriver=='sqlite') {
            $sql = "
            CREATE TABLE `contents_settings` (
            	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            	`content_type` TEXT NOT NULL,
            	`tagline` TEXT,
            	`text` TEXT,
            	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            	`updated_at` DATETIME);
            ";
        }
        
        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
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
            `darkmode` VARCHAR(7) NULL DEFAULT '',
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
                `darkmode` VARCHAR(7) NULL,
                `blog_url` TEXT,
                `lang_short` TEXT NOT NULL,
                `footer` TEXT NOT NULL )';
        }
        
        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
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
        $sql = "
        CREATE TABLE `users` (
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
            $sql='
            CREATE TABLE "users" ( 
                `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
                `firstname` TEXT NOT NULL, 
                `lastname` TEXT NOT NULL, 
                `email` TEXT NOT NULL, 
                `password` TEXT NOT NULL, 
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP, 
                `updated_at` DATETIME, 
                `username` TEXT NOT NULL, 
                `active` TEXT )';
        }

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
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
        $sql = '
        INSERT INTO `settings`(
            `title`, 
            `tagline`, 
            `theme`, 
            `blog_url`, 
            `lang_short`, 
            `footer`)
            VALUES (
                :title, 
                :tagline, 
                :theme, 
                :blog_url, 
                :lang_short, 
                :footer)
        ';

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
            return false;
        }
    }
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
        $sql = "
        INSERT INTO `contents_settings`(
            `content_type`, 
            `tagline`, 
            `text`) 
            VALUES ('link','','');
        ";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
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
        $sql = "
        INSERT INTO `contents_settings`(
            `content_type`,
            `tagline`, 
            `text`) 
            VALUES ('download','','');
        ";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
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
        $sql = "
        INSERT INTO `contents_settings`(
            `content_type`,
            `tagline`, 
            `text`) 
            VALUES ('article','','');
        ";

        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
}

function writeMainpageConfiguration(PDO $pdo) : bool
{
    if ( checkDatabase($pdo) ) {
        $sql = "
        INSERT INTO `contents`(
			`title`,
            `content_type`,
            `text`,
			`visibility`,
            `flag`)
            VALUES ('Infobox','mainpage','Hier steht noch nichts drin','true','infobox');
        ";
        
        try {
            $pdo->exec($sql);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }
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

        // checking for existed mysql database. If the database is exists, then go into loop
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

/**
 * Create an user.
 * 
 * @param PDO $pdo          - Database connection.
 * @param string $firstname - Firstname of an user.
 * @param string $lastname  - Lastname of an user.
 * @param string $email     - Email of an user.
 * @param string $password  - Password of an user. 
 * @param string $username  - Username of an user.
 * @param string $active    - Activity of an user.
 * 
 * @return boolean
 * 
 * @since 0.5.0
 */
function createUser(PDO $pdo, 
    string $firstname, 
    string $lastname, 
    string $email, 
    string $password, 
    string $username, 
    string $active = 'true')
{
    if ( checkDatabase($pdo) ) {

        $sql = '
        INSERT INTO `users`(
            `firstname`, 
            `lastname`, 
            `email`, 
            `password`, 
            `username`, 
            `active`)
            VALUES (
                :firstname, 
                :lastname, 
                :email, 
                :password, 
                :username, 
                :active);
        ';
        
        try {

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':active', $active);

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
}