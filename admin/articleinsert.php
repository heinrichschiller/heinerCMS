<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/general_functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';


/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */

if (is_logged_in ()) {

    $pdo = getPdoDB();
    
    $title   = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');
    $visible = filter_input(INPUT_POST, 'visible');


    $sql = "INSERT INTO `articles` (`title`, `content`, `visible`)"
        . " VALUES (:title, :content, :visible)";
    
    $input_parameters = [
        ':title'   => $title,
        ':content' => $content,
        ':visible' => $visible
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
    } catch (Exception $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    header ( 'Location: index.php?uri=articles' );
}

