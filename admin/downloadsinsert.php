<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    
	$title    = filter_input(INPUT_POST, 'title');
	$comment  = filter_input(INPUT_POST, 'comment');
	$path     = filter_input(INPUT_POST,'path');
	$filename = filter_input(INPUT_POST,'filename');
	$visible  = filter_input(INPUT_POST,'visible');
	
	$pdo = getPdoDB();
	
    $sql = "INSERT INTO downloads (title,comment,path,filename,visible) VALUES (:title, :comment, :path, :filename, :visible)";
    
    $input_parameters = [
        ':title' => $title,
        ':comment' => $comment,
        ':path' => $path,
        ':filename' => $filename,
        ':visible' => $visible
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    header('Location: index.php?uri=downloads');



}

