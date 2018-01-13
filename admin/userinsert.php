<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/general_functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

if (is_logged_in()) {

    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname  = filter_input(INPUT_POST, 'lastname');
    $username  = filter_input(INPUT_POST, 'username');
    $email     = filter_input(INPUT_POST, 'email');
    $publicAs  = filter_input(INPUT_POST, 'public_as');
    $password1 = filter_input(INPUT_POST, 'password1');
    $password2 = filter_input(INPUT_POST, 'password2');
    $active    = filter_input(INPUT_POST, 'active');
    
    $pdo = getPdoDB();
    
    if ( strcmp($password1, $password2) === 0) {
        $password = $password1;
    } else {
        die("Fehler beim passwort festgestellt.");
    }
    
    $sql = 'INSERT INTO `users`(`firstname`, `lastname`, `email`, `password`, `username`, `active`)'
        . ' VALUES (:firstname, :lastname, :email, :password, :username, :active);';
    
    $input_parameters = [
        ':firstname' => $firstname,
        ':lastname'  => $lastname,
        ':email'     => $email,
        ':password'  => password_hash($password, PASSWORD_DEFAULT),
        ':username'  => $username,
        ':active'    => $active
    ];
    
    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    header ( 'Location: index.php?uri=user' );
}
