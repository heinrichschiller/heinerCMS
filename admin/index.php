<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/admin_functions.inc.php';
include __DIR__ . '/../routes/adm_routes.inc.php';

if (DEBUG_MODE) {
    session_start();
    error_reporting(-1);
    ini_set('display_errors', true);
}

if (is_logged_in ()) {

    $content = '';
    $defaultStyle = 'default.css';
    $defaultDarkStyle = 'default-dark.css';
    $editor = "tinymce.init({ selector:'textarea#text'});";
    $editorDark = "tinymce.init({ selector:'textarea', skin: 'dark' });";
    
    $uri = isset($_GET['uri']) ? filter_input ( INPUT_GET, 'uri' ) : 'dashboard';
    $id = filter_input ( INPUT_GET, 'id' );

    $arr_language = get_translation($_SESSION['language']);
    
	$template = getTemplate( 'adm_template' );
	
	if(isset($route[$uri])) {
		$content = $route[$uri]($id);
	}

	$placeholderList = [
	    '##placeholder-language##'   => $_SESSION['language'],
	    '##placeholder-title##'      => $_SESSION['title'],
	    '##placeholder-style##'      => empty($_SESSION['darkmode']) ? $defaultStyle : $defaultDarkStyle,
	    '##placeholder-navigation##' => load_navigation(),
	    '##placeholder-content##'    => $content,
	    '##placeholder-editor##'     => empty($_SESSION['darkmode']) ? $editor : $editorDark,
	    '##placeholder-footer##'     => $_SESSION['footer']
	];
	
	/* Replace all placeholder */
	$template = strtr($template, $placeholderList);
	
	/* translation */
	$template = strtr($template, $arr_language);
	
	/* Output the page */
	echo stripslashes ( $template );
}


