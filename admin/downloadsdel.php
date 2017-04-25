<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
	$id = filter_input(INPUT_POST, 'id');
	
	$con = getDB();
	
	if ($con) {
		$sql = "DELETE FROM downloads WHERE id = $id";
		$result = mysqli_query ( $con, $sql );
		header ( 'Location: index.php?uri=downloads' );
	}

	mysqli_close( $con );
}

