<?php

/* Konfigurationsdateien laden */
include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/general_functions.inc.php';
include __DIR__ . '/../inc/admin_functions.inc.php';
include __DIR__ . '/routes.php';
include __DIR__ . '/../inc/login.inc.php';

// models
include __DIR__ . '/../source/models/user/UserListModel.php';

// views
include __DIR__ . '/../source/views/user/UserListView.php';


$uri = filter_input ( INPUT_GET, 'uri' );
$id = filter_input ( INPUT_GET, 'id' );

// Einfaches Login zu demonstrationszwecken UND ONHE VERSCHLUESSELUNG.
if (is_logged_in ()) {
	
    $config = __DIR__ . '/../source/configs/config.ini';
    $xmlfile = __DIR__ . '/../data/locales/de.xml';
    
    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);
        $_SESSION['theme'] = $ini_array['theme'];
    }

    $xmlString = file_get_contents($xmlfile);
    $xml = simplexml_load_string($xmlString);

    $arr_keys = [];
    $arr_values = [];
    $arr_language = [];
    
    foreach ($xml->children() as $second_gen) {
        foreach ($second_gen->children() as $third_gen) {
            array_push( $arr_keys, '{'.$third_gen->getName().'}');
            array_push( $arr_values, (string)$third_gen);
        }
    }

    $arr_language = array_combine($arr_keys, $arr_values);
    
	/* Template einlesen */
	$template = loadTemplate( 'adm_template' );
	
	if(isset($route[$uri])) {
		$base['adm_content'] = $route[$uri]($id);
	}
	
	/* Platzhalter ersetzen */
	$template = str_replace ( '<@title@>', $base ['adm_title'], $template );
	$template = str_replace ( '<@navigation@>', load_admin_navigation(), $template );
	$template = str_replace ( '<@content@>', $base ['adm_content'], $template );
	$template = str_replace ( '$PHP_SELF', $_SERVER ['PHP_SELF'], $template );
	
	/* translation */
	$template = strtr($template, $arr_language);
	
	/* Template ausgeben */
	echo stripslashes ( $template );
}


