<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
	$id = filter_input(INPUT_POST, 'id');
	$title = filter_input(INPUT_POST, 'title');
	$content = filter_input(INPUT_POST, 'content');
	$visible = filter_input(INPUT_POST, 'visible');
	
	$con = getDB();

	if ($con) {
		$sql = "INSERT INTO articles (title,content,visible) VALUES ('$title','$content',$visible)";
		$result = mysqli_query ( $con, $sql );
		header ( 'Location: index.php?uri=articles' );
	}
	mysqli_close( $con );
}

