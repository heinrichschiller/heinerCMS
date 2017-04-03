<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
	$id = filter_input(INPUT_POST, 'id');
	$title = filter_input(INPUT_POST, 'title');
	$message = filter_input(INPUT_POST, 'messager');
	$visible = filter_input(INPUT_POST, 'visible');

	$con = getDB();

	if ($con) {
		$sql = "UPDATE news SET title = '$title', message = '$message', visible = $visible WHERE id = $id";
		$result = mysqli_query ( $con, $sql );
		header ( 'Location: index.php?uri=news' );
	}
}

