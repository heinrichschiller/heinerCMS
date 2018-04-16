<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/admin_functions.inc.php';
include __DIR__ . '/routes.php';
include __DIR__ . '/../include/login.inc.php';

if (is_logged_in ()) {

    $content = '';
    
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
	    '##placeholder-navigation##' => load_navigation(),
	    '##placeholder-content##'    => $content,
	    '##placeholder-footer##'     => $_SESSION['footer']
	];
	
	/* Replace all placeholder */
	$template = strtr($template, $placeholderList);
	
	/* translation */
	$template = strtr($template, $arr_language);
	
	/* Output the page */
	echo stripslashes ( $template );
}


