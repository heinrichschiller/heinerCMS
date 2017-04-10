<?php
error_reporting ( - 1 );
ini_set ( 'display_errors', true );

/* Konfigurationsdateien laden */
include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/routes.php';
include __DIR__ . '/../inc/login.inc.php';

$uri = filter_input ( INPUT_GET, 'uri' );
$id = filter_input ( INPUT_GET, 'id' );

/* Einfaches Logging zu demonstationszwecken UND ONHE VERSCHLUESSELUNG. */
if (is_logged_in ()) {
	
	/* Template einlesen */
	$template = file_get_contents ( $base ['adm_template'] );

	if(isset($route[$uri])) {
		$base['adm_content'] = $route[$uri]($id);
	}
	
	/* Platzhalter ersetzen */
	$template = str_replace ( '###title###', $base ['adm_title'], $template );
	$template = str_replace ( '###navigation###', $base ['adm_navigation'], $template );
	$template = str_replace ( '###content###', $base ['adm_content'], $template );
	$template = str_replace ( '$PHP_SELF', $_SERVER ['PHP_SELF'], $template );
	
	/* Template ausgeben */
	echo stripslashes ( $template );
}


