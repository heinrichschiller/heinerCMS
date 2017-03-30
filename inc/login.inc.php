<?php

/* Session initialisieren */
session_start();
  
/* Überprüft, ob ein Login erfolgt ist */
function is_logged_in()
{
    global $base;
    
    /* User angemeldet? */
    if($_SESSION['authenticated'] == true) {
      return true;
    } else {
      $content = '<h4>Login</h4>';
      $content .= '<form action="login.php" method="post">';
      $content .= '<table border="0" cellpadding="2" cellspacing="0">';
      $content .= '<tr>';
      $content .= '<td>Benutzername:</td><td><input type="text" name="username" size="32" maxlength="64"></td>';
      $content .= '</tr><tr>';
      $content .= '<td>Passwort:</td><td><input type="password" name="password" size="32"></td>';
      $content .= '</tr><tr>';
      $content .= '<td></td><td><input type="submit" value="Login"></td>';
      $content .= '</tr>';
      $content .= '</table>';
      $content .= '</form>';
      
      $template = get_file_as_string($base['adm_template']);
      $template = str_replace('###title###',$base['adm_title'],$template);
      $template = str_replace('###shortnav###','&nbsp;',$template);
      $template = str_replace('###navigation###','&nbsp;',$template);
      $template = str_replace('###content###',$content,$template);
      $template = str_replace('$PHP_SELF',$PHP_SELF,$template);
      echo stripslashes($template);
      return false;
    }
  }

?>
