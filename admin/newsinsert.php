<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {
    
    $pdo = getPdoDB();
    
    $title   = filter_input(INPUT_POST, 'title');
    $message = filter_input(INPUT_POST, 'message');
    $visible = filter_input(INPUT_POST, 'visible');
    
    $sql = 'INSERT INTO `news` (`title`,`message`,`visible`)'
        . " VALUES (:title, :message, :visible)";
    
    $input_parameters = [
        ':title'   => $title,
        ':message' => $message,
        ':visible' => $visible
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    header('Location: index.php?uri=news');
}

