<?php

session_start();

include __DIR__ . '/../config/cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';

$email = filter_input(INPUT_POST, 'email');
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$login_password = filter_input(INPUT_POST, 'password');

try {
    $pdo = getPdoConnection();

    $sql = "SELECT `id`,`email`,`username`,`password` FROM `users` WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(array('email' => $email));
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