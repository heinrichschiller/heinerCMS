<?php

session_start();

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';

if (!checkSystem()) {
    header("Location: /../_installer_/index.php?uri=language&lang=en&db=mysql");
    exit();
}

$email = filter_input(INPUT_POST, 'email');
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$login_password = filter_input(INPUT_POST, 'password');

try {
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`,
        `email`,
        `username`,
        `password` 
        FROM `users` 
        WHERE email = :email
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array('email' => $email));
    $user = $stmt->fetch();

} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit();
}

if ($user !== false && password_verify($login_password, $user['password'])) {
    $_SESSION['authenticated'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header('Location: index.php?uri=dashboard');
} else {
    $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    echo $errorMessage;
    exit();
}