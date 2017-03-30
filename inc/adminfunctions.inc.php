<?php

  /* Gesamtübersicht der Nachrichten laden */
  function load_admin_news()
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM news ORDER BY datetime DESC';
      $result = mysql_query($sql);
      if($result)
      {
        $tmprslt .= "<p><a href=\"$_SERVER[PHP_SELF]?cmd=newsadd\">News erstellen</a></p>";
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Sichtbar?</th><th>Ops</th></tr>';
        while($news = mysql_fetch_object($result))
        {
          $tmprslt .= '<tr><td>'.StrFTime('%d.%m.%Y %H:%M:%S',$news->datetime)."</td><td>$news->title</td><td>".(($news->visible > -1) ? 'ja' : 'nein')."</td><td><a href=\"$_SERVER[PHP_SELF]?cmd=newsedit&id=$news->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?cmd=newsdel&id=$news->id\">Löschen</a></tr>";
        }
        $tmprslt .= '</table>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Bearbeiten einer Nachricht laden */
  function load_admin_newsedit($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, message, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM news WHERE id = '.$id;
      $result = mysql_query($sql);
      if($result)
      {
        $news = mysql_fetch_object($result);
		    $tmprslt .= '<form action="newsupdate.php" method="post">';
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>ID:</th><td>'.$news->id.'<input type="hidden" name="id" value="'.$news->id.'"></td></tr>';
        $tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="'.$news->title.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>Datum:</th><td>'.StrFTime('%d.%m.%Y %H:%M:%S',$news->datetime).'</td></tr>';
        $tmprslt .= '<tr><th>Text:</th><td><textarea name="message" cols="64" rows="16">'.$news->message.'</textarea></td></tr>';
				$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"'.
											(($news->visible > -1) ? ' checked' : '').
											'> ja <input type="radio" name="visible" value="-1"'.
											(($news->visible < 0) ? ' checked' : '').
											'> nein</td></tr>';
				$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
        $tmprslt .= '</table>';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Erstellen einer Nachricht laden */
  function load_admin_newsadd($id)
  {
    $tmprslt = '';
		$tmprslt .= '<form action="newsinsert.php" method="post">';
		$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
		$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" size="64"></td></tr>';
		$tmprslt .= '<tr><th>Datum:</th><td>'.StrFTime('%d.%m.%Y %H:%M:%S',time()).'</td></tr>';
		$tmprslt .= '<tr><th>Text:</th><td><textarea name="message" cols="64" rows="16"></textarea></td></tr>';
		$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0" checked> ja <input type="radio" name="visible" value="-1"> nein</td></tr>';
		$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
		$tmprslt .= '</table>';
		$tmprslt .= '</form>';
    return $tmprslt;
  }

  /* Nachricht löschen */
  function load_admin_newsdel($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = "SELECT title FROM news WHERE id = $id";
      $result = mysql_query($sql);
      if($result)
      {
        $news = mysql_fetch_object($result);
        $tmprslt .= '<form action="newsdel.php" method="post">';
        $tmprslt .= '<p>Möchten Sie die Nachricht <b>'.$news->title.'</b> wirklich löschen?</p>';
        $tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?cmd=news\'"></p>';
        $tmprslt .= '<input type="hidden" name="id" value="'.$id.'">';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Gesamtübersicht der Downloads laden */
  function load_admin_downloads()
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime, path, filename, visible FROM downloads ORDER BY datetime DESC';
      $result = mysql_query($sql);
      if($result)
      {
        $tmprslt .= "<p><a href=\"$_SERVER[PHP_SELF]?cmd=downloadsadd\">Download hinzufügen</a></p>";
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Pfad</th><th>Sichtbar?</th><th>Ops</th></tr>';
        while($downloads = mysql_fetch_object($result))
        {
          $tmprslt .= '<tr><td>'.StrFTime('%d.%m.%Y %H:%M:%S',$downloads->datetime)."</td><td>$downloads->title</td><td>$downloads->path$downloads->filename</td><td>".(($downloads->visible > -1) ? 'ja' : 'nein')."</td><td><a href=\"$_SERVER[PHP_SELF]?cmd=downloadsedit&id=$downloads->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?cmd=downloadsdel&id=$downloads->id\">Löschen</a></tr>";
        }
        $tmprslt .= '</table>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Bearbeiten eines Downloads laden */
  function load_admin_downloadsedit($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, comment, UNIX_TIMESTAMP(datetime) AS datetime, path, filename, visible FROM downloads ORDER BY datetime DESC';
      $result = mysql_query($sql);
      if($result)
      {
        $downloads = mysql_fetch_object($result);
		    $tmprslt .= '<form action="downloadsupdate.php" method="post">';
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>ID:</th><td>'.$downloads->id.'<input type="hidden" name="id" value="'.$downloads->id.'"></td></tr>';
        $tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="'.$downloads->title.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>Datum:</th><td>'.StrFTime('%d.%m.%Y %H:%M:%S',$downloads->datetime).'</td></tr>';
        $tmprslt .= '<tr><th>Pfad:</th><td><input type="text" name="path" value="'.$downloads->path.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>Dateiname:</th><td><input type="text" name="filename" value="'.$downloads->filename.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>Kommentar:</th><td><textarea name="comment" cols="64" rows="16">'.$downloads->comment.'</textarea></td></tr>';
				$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"'.
											(($downloads->visible > -1) ? ' checked' : '').
											'> ja <input type="radio" name="visible" value="-1"'.
											(($downloads->visible < 0) ? ' checked' : '').
											'> nein</td></tr>';
				$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
        $tmprslt .= '</table>';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }
  
  /* Formular zum Erstellen eines Downloads laden */
  function load_admin_downloadsadd($id)
  {
    $tmprslt = '';
		$tmprslt .= '<form action="downloadsinsert.php" method="post">';
		$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
		$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="'.$downloads->title.'" size="64"></td></tr>';
		$tmprslt .= '<tr><th>Datum:</th><td>'.StrFTime('%d.%m.%Y %H:%M:%S',time()).'</td></tr>';
		$tmprslt .= '<tr><th>Pfad:</th><td><input type="text" name="path" size="64"></td></tr>';
		$tmprslt .= '<tr><th>Dateiname:</th><td><input type="text" name="filename" size="64"></td></tr>';
		$tmprslt .= '<tr><th>Kommentar:</th><td><textarea name="comment" cols="64" rows="16"></textarea></td></tr>';
		$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0" checked> ja <input type="radio" name="visible" value="-1"> nein</td></tr>';
		$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
		$tmprslt .= '</table>';
		$tmprslt .= '</form>';
    return $tmprslt;
  }

  /* Download löschen */
  function load_admin_downloadsdel($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = "SELECT title FROM downloads WHERE id = $id";
      $result = mysql_query($sql);
      if($result)
      {
        $news = mysql_fetch_object($result);
        $tmprslt .= '<form action="downloadsdel.php" method="post">';
        $tmprslt .= '<p>Möchten Sie den Download <b>'.$news->title.'</b> wirklich löschen?</p>';
        $tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?cmd=downloads\'"></p>';
        $tmprslt .= '<input type="hidden" name="id" value="'.$id.'">';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Gesamtübersicht der Links laden */
  function load_admin_links()
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, uri, visible FROM links ORDER BY title DESC';
      $result = mysql_query($sql);
      if($result)
      {
        $tmprslt .= "<p><a href=\"$_SERVER[PHP_SELF]?cmd=linkadd\">Link hinzufügen</a></p>";
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>Title</th><th>URI</th><th>Sichtbar?</th><th>Ops</th></tr>';
        while($links = mysql_fetch_object($result))
        {
          $tmprslt .= "<tr><td>$links->title</td><td>$links->uri</td><td>".(($links->visible > -1) ? 'ja' : 'nein')."</td><td><a href=\"$_SERVER[PHP_SELF]?cmd=linkedit&id=$links->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?cmd=linkdel&id=$links->id\">Löschen</a></tr>";
        }
        $tmprslt .= '</table>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Bearbeiten eines Links laden */
  function load_admin_linkedit($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, uri, comment, visible FROM links WHERE id = '.$id;
      $result = mysql_query($sql);
      if($result)
      {
        $links = mysql_fetch_object($result);
		    $tmprslt .= '<form action="linkupdate.php" method="post">';
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>ID:</th><td>'.$links->id.'<input type="hidden" name="id" value="'.$links->id.'"></td></tr>';
        $tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="'.$links->title.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>URI:</th><td><input type="text" name="uri" value="'.$links->uri.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>Kommentar:</th><td><textarea name="comment" cols="64" rows="16">'.$links->comment.'</textarea></td></tr>';
				$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"'.
											(($links->visible > -1) ? ' checked' : '').
											'> ja <input type="radio" name="visible" value="-1"'.
											(($links->visible < 0) ? ' checked' : '').
											'> nein</td></tr>';
				$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
        $tmprslt .= '</table>';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Erstellen einer Nachricht laden */
  function load_admin_linkadd($id)
  {
    $tmprslt = '';
		$tmprslt .= '<form action="linkinsert.php" method="post">';
		$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
		$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" size="64"></td></tr>';
		$tmprslt .= '<tr><th>URI:</th><td><input type="text" name="uri" size="64"></td></tr>';
		$tmprslt .= '<tr><th>Kommentar:</th><td><textarea name="comment" cols="64" rows="16"></textarea></td></tr>';
		$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0" checked> ja <input type="radio" name="visible" value="-1"> nein</td></tr>';
		$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
		$tmprslt .= '</table>';
		$tmprslt .= '</form>';
    return $tmprslt;
  }
  
  /* Link löschen */
  function load_admin_linkdel($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = "SELECT title, uri FROM links WHERE id = $id";
      $result = mysql_query($sql);
      if($result)
      {
        $links = mysql_fetch_object($result);
        $tmprslt .= '<form action="linkdel.php" method="post">';
        $tmprslt .= '<p>Möchten Sie den Link <b>'.$links->title.' ('.$links->uri.')</b> wirklich löschen?</p>';
        $tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?cmd=links\'"></p>';
        $tmprslt .= '<input type="hidden" name="id" value="'.$id.'">';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }
  /* Gesamtübersicht der Artikel laden */
  function load_admin_articles()
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM articles ORDER BY datetime DESC';
      $result = mysql_query($sql);
      if($result)
      {
        $tmprslt .= "<p><a href=\"$_SERVER[PHP_SELF]?cmd=articleadd\">Artikel erstellen</a></p>";
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Sichtbar?</th><th>Ops</th></tr>';
        while($articles = mysql_fetch_object($result))
        {
          $tmprslt .= '<tr><td>'.StrFTime('%d.%m.%Y %H:%M:%S',$articles->datetime)."</td><td>$articles->title</td><td>".(($articles->visible > -1) ? 'ja' : 'nein')."</td><td><a href=\"$_SERVER[PHP_SELF]?cmd=articleedit&id=$articles->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?cmd=articledel&id=$articles->id\">Löschen</a></tr>";
        }
        $tmprslt .= '</table>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Bearbeiten eines Artikels laden */
  function load_admin_articleedit($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = 'SELECT id, title, content, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM articles WHERE id = '.$id;
      $result = mysql_query($sql);
      if($result)
      {
        $articles = mysql_fetch_object($result);
		    $tmprslt .= '<form action="articleupdate.php" method="post">';
        $tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
        $tmprslt .= '<tr><th>ID:</th><td>'.$articles->id.'<input type="hidden" name="id" value="'.$articles->id.'"></td></tr>';
        $tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="'.$articles->title.'" size="64"></td></tr>';
        $tmprslt .= '<tr><th>Datum:</th><td>'.StrFTime('%d.%m.%Y %H:%M:%S',$articles->datetime).'</td></tr>';
        $tmprslt .= '<tr><th>Inhalt:</th><td><textarea name="content" cols="64" rows="16">'.$articles->content.'</textarea></td></tr>';
				$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"'.
											(($articles->visible > -1) ? ' checked' : '').
											'> ja <input type="radio" name="visible" value="-1"'.
											(($articles->visible < 0) ? ' checked' : '').
											'> nein</td></tr>';
				$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
        $tmprslt .= '</table>';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

  /* Formular zum Erstellen eines Artikels laden */
  function load_admin_articleadd($id)
  {
    $tmprslt = '';
		$tmprslt .= '<form action="articleinsert.php" method="post">';
		$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
		$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" size="64"></td></tr>';
		$tmprslt .= '<tr><th>Datum:</th><td>'.StrFTime('%d.%m.%Y %H:%M:%S',time()).'</td></tr>';
		$tmprslt .= '<tr><th>Inhalt:</th><td><textarea name="content" cols="64" rows="16"></textarea></td></tr>';
		$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0" checked> ja <input type="radio" name="visible" value="-1"> nein</td></tr>';
		$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
		$tmprslt .= '</table>';
		$tmprslt .= '</form>';
    return $tmprslt;
  }

  /* Artikel löschen */
  function load_admin_articledel($id)
  {
    include('../inc/database.inc.php');
    $tmprslt = '';
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = "SELECT title FROM articles WHERE id = $id";
      $result = mysql_query($sql);
      if($result)
      {
        $articles = mysql_fetch_object($result);
        $tmprslt .= '<form action="articledel.php" method="post">';
        $tmprslt .= '<p>Möchten Sie den Artikel <b>'.$articles->title.'</b> wirklich löschen?</p>';
        $tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?cmd=articles\'"></p>';
        $tmprslt .= '<input type="hidden" name="id" value="'.$id.'">';
        $tmprslt .= '</form>';
      }
      mysql_close();
    }
    return $tmprslt;
  }

?>
