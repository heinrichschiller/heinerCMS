<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/general_functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    
	$id       = filter_input(INPUT_POST, 'id');
	$title    = filter_input(INPUT_POST, 'title');
	$comment  = filter_input(INPUT_POST, 'comment');
	$path     = filter_input(INPUT_POST,'path');
	$filename = filter_input(INPUT_POST,'filename');
	$visible  = filter_input(INPUT_POST,'visible');
	
    $pdo = getPdoDB();
    
    $sql = "UPDATE downloads SET title = :title, comment = :comment, path = :path, filename = :filename, visible = :visible WHERE id = :id";
    
    $input_parameters = [
        ':title'    => $title,
        ':comment'  => $comment,
        ':path'     => $path,
        ':filename' => $filename,
        ':visible'  => $visible,
        ':id'       => $id
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
