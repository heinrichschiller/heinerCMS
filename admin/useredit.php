<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in()) {

    $id        = filter_input(INPUT_POST, 'id');
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname  = filter_input(INPUT_POST, 'lastname');
    $username  = filter_input(INPUT_POST, 'username');
    $email     = filter_input(INPUT_POST, 'email');
    $active    = filter_input(INPUT_POST, 'active');

    $pdo = getPdoConnection();

    $sql = 'UPDATE `users` SET `firstname`= :firstname
        ,`lastname`= :lastname
        ,`email`= :email
        ,`username`= :username
        ,`active`= :active
        WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':active', $active);

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header ( 'Location: index.php?uri=user' );
}