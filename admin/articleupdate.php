<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {
    
    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');
    $visible = filter_input(INPUT_POST, 'visible');
    
    $pdo = getPdoDB();
    
    $sql = "UPDATE `articles` SET `title` = :title, `content` = :content, `visible` = :visible WHERE `id` = :id";

    $input_parameters = [
        ':title'   => $title,
        ':content' => $content,
        ':visible' => $visible,
        ':id'      => $id
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
    
    } catch (PDOException $ex) {
    
        echo $ex->getMessage();
        exit();
        
    }
    
    header('Location: index.php?uri=articles');
}

