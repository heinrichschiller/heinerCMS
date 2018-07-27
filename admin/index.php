<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/admin_functions.inc.php';
include __DIR__ . '/routes.php';

if (is_logged_in ()) {

    $content = '';
    $defaultStyle = 'default.css';
    $defaultDarkStyle = 'default-dark.css';
    $editor = "tinymce.init({ selector:'textarea'});";
    $editorDark = "tinymce.init({ selector:'textarea', skin: 'dark' });";
    
    $uri = filter_input ( INPUT_GET, 'uri' );
    $id = filter_input ( INPUT_GET, 'id' );

    $arr_language = get_translation($_SESSION['language']);
    
	$template = loadTemplate( 'adm_template' );
	
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


