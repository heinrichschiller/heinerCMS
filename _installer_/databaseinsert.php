<?php

session_start();

$address  = filter_input(INPUT_POST, 'address');
$database = filter_input(INPUT_POST, 'database');
$new_db   = filter_input(INPUT_POST, 'new_db');
$user     = filter_input(INPUT_POST, 'user');
$password = filter_input(INPUT_POST, 'password');
$language = filter_input(INPUT_GET, 'lang');

/**
 * This vars comes with get or post request :-(
 * from mysql_form.tpl.php(post) and sqlite_form.tpl.php(get)
 */
if (isset($_GET['db'])) {
    $dbDriver = filter_input(INPUT_GET, 'db');
} else {
    $dbDriver = filter_input(INPUT_POST, 'db');
}

try {
    if ($dbDriver == 'mysql') {
        $pdo = new PDO("mysql:host=$address;", $user, $password);

        $_SESSION['address']     = $address;
        $_SESSION['database']    = $database;
        $_SESSION['new_db']      = $new_db;
        $_SESSION['db_user']     = $user;
        $_SESSION['db_password'] = $password;
    }

    $_SESSION['db_driver'] = $dbDriver;

    $_SESSION['isConnected'] = true;
    
} catch (PDOException $ex) {
    echo 'Connection failed: ' . $ex->getMessage();
    $_SESSION['isConnected'] = false;
    exit();
}

header('Location: index.php?uri=user&lang=' .$language . '&db=' . $dbDriver);
