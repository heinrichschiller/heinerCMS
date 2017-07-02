<?php

/* Konfigurationsdateien laden */
include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/routes.php';
include __DIR__ . '/../inc/login.inc.php';

// models
include __DIR__ . '/../source/models/user/UserListModel.php';

// views
include __DIR__ . '/../source/views/user/UserListView.php';


$uri = filter_input ( INPUT_GET, 'uri' );
$id = filter_input ( INPUT_GET, 'id' );

/* Einfaches Logging zu demonstationszwecken UND ONHE VERSCHLUESSELUNG. */
if (is_logged_in ()) {
	
	/* Template einlesen */
	$template = loadTemplate( 'adm_template' );
	
	if(isset($route[$uri])) {
		$base['adm_content'] = $route[$uri]($id);
	}
	
	/* Platzhalter ersetzen */
	$template = str_replace ( '###title###', $base ['adm_title'], $template );
	$template = str_replace ( '###navigation###', load_admin_navigation(), $template );
	$template = str_replace ( '###content###', $base ['adm_content'], $template );
	$template = str_replace ( '$PHP_SELF', $_SERVER ['PHP_SELF'], $template );
	
	/* Template ausgeben */
	echo stripslashes ( $template );
}


