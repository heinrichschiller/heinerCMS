<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
	$id = filter_input(INPUT_POST, 'id');
	$action = filter_input(INPUT_POST, 'action');

	$uri = '';

	// @todo Unsicher!!! Beheben!!!
	$list = isset($_POST['chk_select']) ? $_POST['chk_select'] : array();

	switch ( $action ) {
	    case 'del_newsList' : deleteItemsById($list, 'news');
	       $uri = 'trash';
	       break;
	    case 'del_all' : deleteAllTrashItems('news');
    	    $uri = 'trash';
    	    break;
	    default: setFlagTrashById($id, 'news');
	       $uri = 'news';
	}
	
	header ( "Location: index.php?uri=$uri" );
}
