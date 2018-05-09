<?php

/**
 * @author: Heinrich Schiller
 * @license: MIT
 * @version: 1.0.0
 * 
 * @desc: Simple installer
 */
include __DIR__ . '/include/functions.inc.php';

$language = filter_input(INPUT_GET, 'lang');

$configPath = __DIR__ . '/../cms-config.php';

if (file_exists($configPath)) {
    include $configPath;
} else {
    echo 'Keine konfigurationsdatei gefunden!';
    exit();
}

try {
    // 1. Create database connection
    if ($_SESSION['db_driver'] == 'mysql') {
        $pdo = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASSWORD);

        // 2. Select database
        selectDatabase($pdo, DB_NAME);
    } else {
        $sqliteName = __DIR__ . '/../data/sqlite/heinercms.db';
        $pdo = new PDO("sqlite:$sqliteName");
    }

    if ( $_SESSION['new_db'] == 1 ) {
        $_SESSION['isDatabaseCreated'] = createDatabase($pdo, DB_NAME);
    }

    $dbDriver = $_SESSION['db_driver'];

    $_SESSION['isTabArticlesCreated']          = createTableArticles($pdo, $dbDriver);
    $_SESSION['isTabArticlesSettingsCreated']  = createTableArticlesSettings($pdo, $dbDriver);
    $_SESSION['isTabDownloadsCreated']         = createTableDownloads($pdo, $dbDriver);
    $_SESSION['isTabDownloadsSettingsCreated'] = createTableDownloadsSettings($pdo, $dbDriver);
    $_SESSION['isTabLinksCreated']             = createTableLinks($pdo, $dbDriver);
    $_SESSION['isTabLinksSettingsCreated']     = createTableLinksSettings($pdo, $dbDriver);
    $_SESSION['isTabNewsCreated']              = createTableNews($pdo, $dbDriver);
    $_SESSION['isTabNewsSettingsCreated']      = createTableNewsSettings($pdo, $dbDriver);
    $_SESSION['isTabSitesCreated']             = createTableSites($pdo, $dbDriver);
    $_SESSION['isTabUsersCreated']             = createTableUsers($pdo, $dbDriver);
    $_SESSION['isTabSettingsCreated']          = createTableSettings($pdo, $dbDriver);

    // 4. Write default configuration
    $_SESSION['isDefaultConfWritten']   = writeDefaultConfiguration($pdo);
    $_SESSION['isLinksConfWritten']     = writeLinksSettingsConfiguration($pdo);
    $_SESSION['isNewsConfWritten']      = writeNewsSettingsConfiguration($pdo);
    $_SESSION['isDownloadsConfWritten'] = writeDownloadsSettingsConfiguration($pdo);
    $_SESSION['isArticlesConfWritten']  = writeArticlesSettingsConfiguration($pdo);

} catch (PDOException $ex) {
    echo 'Connection failed: ' . $ex->getMessage();
    exit();
}

// 5. Create user
if ( strcmp($_SESSION['password1'], $_SESSION['password2']) === 0) {
    $password = $_SESSION['password1'];
} else {
    die("Fehler beim passwort festgestellt.");
}

if ( checkDatabase($pdo) ) {
    
    $sql = 'INSERT INTO `users`(`firstname`, `lastname`, `email`, `password`, `username`, `active`)'
        . ' VALUES (:firstname, :lastname, :email, :password, :username, :active);';
        
    $input_parameters = [
        ':firstname' => $_SESSION['firstname'],
        ':lastname'  => $_SESSION['lastname'],
        ':email'     => $_SESSION['email'],
        ':password'  => password_hash($password, PASSWORD_DEFAULT),
        ':username'  => $_SESSION['username'],
        ':active'    => 'true'
    ];

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);

        $_SESSION['isUserCreated'] = true;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

} else {
    $_SESSION['isUserCreated'] = false;
}

header('Location: index.php?uri=final&lang='.$language.'&db='.$_SESSION['db_driver']);