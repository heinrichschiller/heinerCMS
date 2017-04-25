<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
	$id = filter_input(INPUT_POST, 'id');
	$title = filter_input(INPUT_POST, 'title');
	// @todo prüfen!!! uri überschneidet sich mit router=>uri
	$uri = filter_input(INPUT_POST, 'uri');
	$comment = filter_input(INPUT_POST, 'comment');
	$visible = filter_input(INPUT_POST, 'visible');

	$con = getDB();

	if ($con) {
		$sql = "INSERT INTO links (title,comment,uri,visible) VALUES ('$title','$comment','$uri',$visible)";
		$result = mysqli_query ( $con, $sql );
		header ( 'Location: index.php?uri=links' );
	}

	mysqli_close( $con );
}

