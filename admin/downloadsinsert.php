<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
	$id = filter_input(INPUT_POST, 'id');
	$title = filter_input(INPUT_POST, 'title');
	$comment = filter_input(INPUT_POST, 'comment');
	$path = filter_input(INPUT_POST,'path');
	$filename = filter_input(INPUT_POST,'filename');
	$visible = filter_input(INPUT_POST,'visible');
	
	$con = getDB();

	if ($con) {
		$sql = "INSERT INTO downloads (title,comment,path,filename,visible) VALUES ('$title','$comment','$path','$filename',$visible)";
		$result = mysqli_query ( $con, $sql );
		header ( 'Location: index.php?uri=downloads' );
	}

	mysqli_close( $con );
}

