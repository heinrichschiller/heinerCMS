<?php

session_start ();

include_once __DIR__ . '/admin_functions.inc.php';

/* Überprüft, ob ein Login erfolgt ist */
function is_logged_in() {

	$PHP_SELF = $_SERVER['PHP_SELF'];

	$authenticated = isset($_SESSION['authenticated']) ? true : false;

	load_session();
	
	/* User angemeldet? */
	if ($authenticated) {
		return true;
	} else {
		$login = loadTemplate('adm_login');
		$template = loadTemplate('login_template');

		$template = str_replace ( '<@title@>', $_SESSION['title'], $template );
		$template = str_replace ( '<@shortnav@>', '&nbsp;', $template );
		$template = str_replace ( '<@navigation@>', '&nbsp;', $template );
		$template = str_replace ( '<@content@>', $login, $template );
		$template = str_replace ( '$PHP_SELF', $PHP_SELF, $template );

		echo stripslashes ( $template );

		return false;
	}
}
