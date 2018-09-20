<?php

/**
 * @author: Heinrich Schiller
 * @license: MIT
 * @version: 1.1.0
 * 
 * @desc: Simple installer for heinerCMS
 */
include __DIR__ . '/include/functions.inc.php';
session_start();
error_reporting(-1);
ini_set('display_errors', true);

$firstname = filter_input(INPUT_POST, 'firstname');
$lastname  = filter_input(INPUT_POST, 'lastname');
$email     = filter_input(INPUT_POST, 'email');
$username  = filter_input(INPUT_POST, 'username');
$password1 = filter_input(INPUT_POST, 'password1');
$password2 = filter_input(INPUT_POST, 'password2');
$language  = filter_input(INPUT_GET, 'lang');

$language = filter_input(INPUT_GET, 'lang');

$configFile = __DIR__ . '/../configs/db-config.php';

if(is_writable($configFile)) {
    $config = getDBConfiguration();
    
    $handle = fopen($configFile, 'w');
    fwrite($handle, $config);
    fclose($handle);
} else {
    // @todo: other way
}

if (file_exists($configFile)) {
    include $configFile;
} else {
    echo 'No configuration file found.';
    exit();
}

try {
    // 1. Create database connection
    if (DB_DRIVER == 'mysql') {
        $pdo = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASSWORD);

        if ( $_SESSION['new_db'] == 1 ) {
            $_SESSION['isDatabaseCreated'] = createDatabase($pdo, DB_NAME);
        }

        // 2. Select database
        selectDatabase($pdo, DB_NAME);
    } else {
        $sqliteName = __DIR__ . '/../data/sqlite/heinercms.db';
        $pdo = new PDO("sqlite:$sqliteName");
    }

    $_SESSION['isTableContentsCreated']         = createTableContents($pdo, DB_DRIVER);
    $_SESSION['isTableContentsSettingsCreated'] = createTableContentsSettings($pdo, DB_DRIVER);
    $_SESSION['isTableUsersCreated']            = createTableUsers($pdo, DB_DRIVER);
    $_SESSION['isTableSettingsCreated']         = createTableSettings($pdo, DB_DRIVER);

    // 4. Write default configuration
    $_SESSION['isDefaultConfWritten']   = writeDefaultConfiguration($pdo);
    $_SESSION['isLinksConfWritten']     = writeLinksSettingsConfiguration($pdo);
    $_SESSION['isDownloadsConfWritten'] = writeDownloadsSettingsConfiguration($pdo);
    $_SESSION['isArticlesConfWritten']  = writeArticlesSettingsConfiguration($pdo);

} catch (PDOException $ex) {
    echo 'Connection failed: ' . $ex->getMessage();
    exit();
}

// 5. Create user
if ( strcmp($password1, $password2) === 0) {
    $password = $password1;
} else {
    die("Fehler beim passwort festgestellt.");
}

$_SESSION['isUserCreated'] = createUser($pdo, $firstname, $lastname, $email, $password, $username);;

header('Location: index.php?uri=final&lang='.$language.'&db='.$_SESSION['db_driver']);