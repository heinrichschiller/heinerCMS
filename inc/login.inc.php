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
		$content .= '<div class="form-group">';
		$content .= '<label for="email">Email:</label>';
		$content .= '<input type="email" name="email" class="form-control" id="email" maxlength="64">';
		$content .= '</div>';
		$content .= '<div class="form-group">';
		$content .= '<label for="passwd">Passwort:</label>';
		$content .= '<input type="password" name="password" class="form-control" id="passwd">';
		$content .= '</div>';
		$content .= '<button class="btn">Login</button>';
		$content .= '</form>';
		
		$template = file_get_contents ( $base ['adm_template'] );
		$template = str_replace ( '###title###', $base ['adm_title'], $template );
		$template = str_replace ( '###shortnav###', '&nbsp;', $template );
		$template = str_replace ( '###navigation###', '&nbsp;', $template );
		$template = str_replace ( '###content###', $content, $template );
		$template = str_replace ( '$PHP_SELF', $PHP_SELF, $template );
		echo stripslashes ( $template );
		return false;
	}
}
