<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';


/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */

if (is_logged_in ()) {

    $pdo = getPdoDB();
    
    $title   = filter_input(INPUT_POST, 'title');
    $tagline = filter_input(INPUT_POST, 'tagline');
    $content = filter_input(INPUT_POST, 'content');
    $visible = filter_input(INPUT_POST, 'visible');


    $sql = "INSERT INTO `sites` (`title`, `tagline`, `content`, `visible`)"
        . " VALUES (:title, :tagline, :content, :visible)";

    $input_parameters = [
        ':title'   => $title,
        ':tagline' => $tagline,
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
    
    header ( 'Location: index.php?uri=sites' );
}

