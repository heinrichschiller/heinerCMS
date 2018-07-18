<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in()) {
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname  = filter_input(INPUT_POST, 'lastname');
    $username  = filter_input(INPUT_POST, 'username');
    $email     = filter_input(INPUT_POST, 'email');
    $password1 = filter_input(INPUT_POST, 'password1');
    $password2 = filter_input(INPUT_POST, 'password2');
    $active    = filter_input(INPUT_POST, 'active');

    if ( strcmp($password1, $password2) === 0) {
        $password = $password1;
    } else {
        // @todo replace this ...
        die("Fehler beim passwort festgestellt.");
    }

    $sql = "INSERT INTO `users`(`firstname`, `lastname`, `email`, `password`, `username`, `active`)
        VALUES (:firstname, :lastname, :email, :password, :username, :active)";

    if (DB_DRIVER == 'sqlite') {
        $created_at = strftime('%Y-%m-%d %H:%M', time());

        $sql = "INSERT INTO `users`(`firstname`, `lastname`, `email`, `password`, `created_at`, `username`, `active`)
            VALUES (:firstname, :lastname, :email, :password, :created_at, :username, :active)";
    }

    $pwHash = password_hash($password, PASSWORD_DEFAULT);
    $pdo = getPdoConnection();

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pwHash);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':active', $active);

        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $created_at);
        }

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header ( 'Location: index.php?uri=user' );
}
