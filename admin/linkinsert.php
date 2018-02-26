<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    
	$title   = filter_input(INPUT_POST, 'title');
	$tagline = filter_input(INPUT_POST, 'tagline');
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// @todo prüfen!!! uri überschneidet sich mit router=>uri
	$uri     = filter_input(INPUT_POST, 'uri');
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$comment = filter_input(INPUT_POST, 'comment');
	$visible = filter_input(INPUT_POST, 'visible');
	
    $pdo = getPdoDB();
    
    $sql = "INSERT INTO links (title, tagline, comment, uri, visible) VALUES (:title, :tagline, :comment, :uri, :visible)";
    
    $input_parameters = [
        ':title' => $title,
        ':tagline' => $tagline,
        ':comment' => $comment,
        ':uri' => $uri,
        ':visible' => $visible
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
    } catch (PDOException $ex) {

        echo $ex->getMessage();
        exit();
        
    }
    
    header('Location: index.php?uri=links');

}

