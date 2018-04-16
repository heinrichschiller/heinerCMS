<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

if (is_logged_in ()) {
    
	$id      = filter_input(INPUT_POST, 'id');
	$title   = filter_input(INPUT_POST, 'title');
	$message = filter_input(INPUT_POST, 'message');
	$visible = filter_input(INPUT_POST, 'visible');

	$pdo = getPdoDB();

	$sql = "UPDATE `news` SET `title` = :title, `message` = :message, `visible` = :visible WHERE `id` = :id";

	$inpuit_parameters = [
	    ':title'   => $title,
	    ':message' => $message,
	    ':visible' => $visible,
	    ':id'      => $id
	];
	
	try {
	    
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute($inpuit_parameters);
	    
	} catch (PDOException $ex) {
	    
	    echo $ex->getMessage();
	    exit();
	    
	}
	
	header ( 'Location: index.php?uri=news');

}

