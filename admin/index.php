<?php
error_reporting ( - 1 );
ini_set ( 'display_errors', true );

/* Konfigurationsdateien laden */
include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/routes.php';
include __DIR__ . '/../inc/login.inc.php';

/* Einfaches Logging zu demonstationszwecken UND ONHE VERSCHLUESSELUNG. */
if (is_logged_in ()) {
	
	$uri = filter_input ( INPUT_GET, 'uri' );
	$id = filter_input ( INPUT_GET, 'id' );
	
	/* Template einlesen */
	$template = file_get_contents ( $base ['adm_template'] );
	
	/* Inhalt laden */
	switch (strtolower ( $uri )) {
		default :
		case 'news' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>News</i></h4>';
			$base ['adm_content'] .= load_admin_news ();
			break;
		case 'newsedit' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>News bearbeiten</i></h4>';
			$base ['adm_content'] .= load_admin_newsedit ( $id );
			break;
		case 'newsadd' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>News erstellen</i></h4>';
			$base ['adm_content'] .= load_admin_newsadd ( $id );
			break;
		case 'newsdel' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>News löschen</i></h4>';
			$base ['adm_content'] .= load_admin_newsdel ( $id );
			break;
		case 'downloads' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Downloads</i></h4>';
			$base ['adm_content'] .= load_admin_downloads ();
			break;
		case 'downloadsedit' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Downloads bearbeiten</i></h4>';
			$base ['adm_content'] .= load_admin_downloadsedit ( $id );
			break;
		case 'downloadsadd' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Download hinzufügen</i></h4>';
			$base ['adm_content'] .= load_admin_downloadsadd ( $id );
			break;
		case 'downloadsdel' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Download löschen</i></h4>';
			$base ['adm_content'] .= load_admin_downloadsdel ( $id );
			break;
		case 'links' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Links</i></h4>';
			$base ['adm_content'] .= load_admin_links ();
			break;
		case 'linkedit' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Links bearbeiten</i></h4>';
			$base ['adm_content'] .= load_admin_linkedit ( $id );
			break;
		case 'linkadd' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Link hinzufügen</i></h4>';
			$base ['adm_content'] .= load_admin_linkadd ( $id );
			break;
		case 'linkdel' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Link löschen</i></h4>';
			$base ['adm_content'] .= load_admin_linkdel ( $id );
			break;
		case 'articles' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Artikel</i></h4>';
			$base ['adm_content'] .= load_admin_articles ();
			break;
		case 'articleedit' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Artikel bearbeiten</i></h4>';
			$base ['adm_content'] .= load_admin_articleedit ( $id );
			break;
		case 'articleadd' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Artikel erstellen</i></h4>';
			$base ['adm_content'] .= load_admin_articleadd ( $id );
			break;
		case 'articledel' :
			$base ['adm_content'] = '<h4>' . $base ['adm_actual'] . '<i>Artikel löschen</i></h4>';
			$base ['adm_content'] .= load_admin_articledel ( $id );
			break;
	}
	
	/* Platzhalter ersetzen */
	$template = str_replace ( '###title###', $base ['adm_title'], $template );
	//$template = str_replace ( '###shortnav###', $base ['adm_shortnav'], $template );
	$template = str_replace ( '###navigation###', $base ['adm_navigation'], $template );
	$template = str_replace ( '###content###', $base ['adm_content'], $template );
	$template = str_replace ( '$PHP_SELF', $_SERVER ['PHP_SELF'], $template );
	
	/* Template ausgeben */
	echo stripslashes ( $template );
}


