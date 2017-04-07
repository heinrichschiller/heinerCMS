<?php

session_start ();

/* Überprüft, ob ein Login erfolgt ist */
function is_logged_in() {
	global $base;
	
	/* User angemeldet? */
	if ($_SESSION ['authenticated'] == true) {
		return true;
	} else {
		$content = '<h4>Login</h4>';
		$content .= '<form action="login.php" method="post">';
		$content .= 'Email:<br><input type="email" name="email" size="32" maxlength="64">';
		$content .= '<br>Passwort:<br><input type="password" name="password" size="32"><br>';
		$content .= '<input type="submit" value="Login">';
		$content .= '</form>';
		
		$template = get_file_as_string ( $base ['adm_template'] );
		$template = str_replace ( '###title###', $base ['adm_title'], $template );
		$template = str_replace ( '###shortnav###', '&nbsp;', $template );
		$template = str_replace ( '###navigation###', '&nbsp;', $template );
		$template = str_replace ( '###content###', $content, $template );
		$template = str_replace ( '$PHP_SELF', $PHP_SELF, $template );
		echo stripslashes ( $template );
		return false;
	}
}
