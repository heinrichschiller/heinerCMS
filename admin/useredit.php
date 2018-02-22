<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

if (is_logged_in()) {

    $id        = filter_input(INPUT_POST, 'id');
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname  = filter_input(INPUT_POST, 'lastname');
    $username  = filter_input(INPUT_POST, 'username');
    $email     = filter_input(INPUT_POST, 'email');
    $publicAs  = filter_input(INPUT_POST, 'public_as');
    $active    = filter_input(INPUT_POST, 'active');

    $pdo = getPdoDB();

    $sql = 'UPDATE `users` SET `id`= :id
        ,`firstname`= :firstname
        ,`lastname`= :lastname
        ,`email`= :email
        ,`username`= :username
        ,`public_as`= :public_as
        ,`active`= :active';
    
    $input_parameters = [
        ':id'        => $id,
        ':firstname' => $firstname,
        ':lastname'  => $lastname,
        ':email'     => $email,
        ':username'  => $username,
        ':public_as' => $publicAs,
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