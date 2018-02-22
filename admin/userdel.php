<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {
    
    $id     = filter_input(INPUT_POST, 'id');
    $action = filter_input(INPUT_POST, 'action');
    
    $pdo = getPdoDB();
    
    $sql = 'DELETE FROM `users` WHERE id = :id';
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $id));
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    header ( "Location: index.php?uri=user" );
}