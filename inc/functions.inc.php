<?php
function getDB()
{
	include __DIR__ . '/database.inc.php';
	
	try {
		return mysqli_connect ( $db ['host'], $db ['uid'], $db ['pwd'], $db ['db'] );
	} catch ( Exception $ex ) {
		echo $ex->getMessage ();
	}
}

/* Gesamtübersicht der Nachrichten laden */
function load_content_news()
{
	$tmprslt = '';
	$con = getDB ();
	
	if ($con) {
		
		$sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime FROM news WHERE visible > -1 ORDER BY datetime DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $news = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= StrFTime ( '%d.%m.%Y %H:%M:%S', $news->datetime );
				$tmprslt .= " - <a href=\"$PHP_SELF?uri=newsdet&id=$news->id\">$news->title</a><br>\n";
			}
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Detailansicht einer Nachricht laden */
function load_content_newsdetailed($id)
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT title, message, UNIX_TIMESTAMP(datetime) AS datetime FROM news WHERE id = ' . $id;
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );
			$tmprslt .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M:%S', $news->datetime ) . "</h5>";
			$tmprslt .= "<h2>$news->title</h2>";
			$tmprslt .= "<p>$news->message</p>";
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Gesamtübersicht der Downloads laden */
function load_content_downloads()
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT id, title FROM downloads WHERE visible > -1 ORDER BY title ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $downloads = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= "<a href=\"$PHP_SELF?uri=downloadsdet&id=$downloads->id\">$downloads->title</a><br>\n";
			}
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Detailansicht eines Downloads laden */
function load_content_downloadsdetailed($id)
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT title, comment, path, filename, UNIX_TIMESTAMP(datetime) AS datetime FROM downloads WHERE id = ' . $id;
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$downloads = mysqli_fetch_object ( $result );
			$tmprslt .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M:%S', $downloads->datetime ) . "</h5>";
			$tmprslt .= "<h2>$downloads->title</h2>";
			$tmprslt .= "<p>$downloads->comment</p>";
			$tmprslt .= "<p><a href=\"$downloads->path$downloads->filename\">Hier klicken!</a></p>";
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Gesamtübersicht der Artikel laden */
function load_content_articles()
{
	$tmprslt = '';
	$con = getDB ();
	
	if ($con) {
		
		$sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime FROM articles WHERE visible > -1 ORDER BY datetime ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $articles = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= StrFTime ( '%d.%m.%Y %H:%M:%S ', $articles->datetime );
				$tmprslt .= "<a href=\"$PHP_SELF?uri=articlesdet&id=$articles->id\">$articles->title</a><br>\n";
			}
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Detailansicht eines Artikels laden */
function load_content_articlesdetailed($id)
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT title, content, UNIX_TIMESTAMP(datetime) AS datetime FROM articles WHERE id = ' . $id;
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$articles = mysqli_fetch_object ( $result );
			$tmprslt .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M:%S', $articles->datetime ) . "</h5>";
			$tmprslt .= "<h2>$articles->title</h2>";
			$tmprslt .= $articles->content;
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Gesamtübersicht der Links laden */
function load_content_links()
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT title, uri, comment FROM links WHERE visible > -1 ORDER BY title ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $links = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= "<p><a href=\"$links->uri\">$links->title</a><br>$links->comment<br><span class=\"uri\">$links->uri</span></p>";
			}
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Admin-Bereich */

/* Gesamtübersicht der Nachrichten laden */
function load_admin_news()
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM news ORDER BY datetime DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$tmprslt .= '<p><a href="$PHP_SELF?uri=newsadd" class="btn btn-primary" role="button">News erstellen</a></p>';
			$tmprslt .= '<table class="table table-hover table-striped">';
			$tmprslt .= '<thead>';
			$tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Sichtbar?</th><th>Aktionen</th></tr>';
			$tmprslt .= '</thead>';
			$tmprslt .= '<tbody>';
			while ( $news = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', $news->datetime ) . "</td><td>$news->title</td><td>" . (($news->visible > - 1) ? 'ja' : 'nein') . "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=newsedit&id=$news->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=newsdel&id=$news->id\">Löschen</a></tr>";
			}
			$tmprslt .= '</tbody>';
			$tmprslt .= '</table>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Formular zum Bearbeiten einer Nachricht laden */
function load_admin_newsedit($id)
{

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = 'SELECT id, title, message, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM news WHERE id = ' . $id;
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="newsupdate.php" method="post">';
			$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
			$tmprslt .= '<tr><th>ID:</th><td>' . $news->id . '<input type="hidden" name="id" value="' . $news->id . '"></td></tr>';
			$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="' . $news->title . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>Datum:</th><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', $news->datetime ) . '</td></tr>';
			$tmprslt .= '<tr><th>Text:</th><td><textarea name="message" cols="64" rows="16">' . $news->message . '</textarea></td></tr>';
			$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"' . (($news->visible > - 1) ? ' checked' : '') . '> ja <input type="radio" name="visible" value="-1"' . (($news->visible < 0) ? ' checked' : '') . '> nein</td></tr>';
			$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
			$tmprslt .= '</table>';
			$tmprslt .= '</form>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Formular zum Erstellen einer Nachricht laden */
function load_admin_newsadd($id)
{
	$tmprslt = '';
	$tmprslt .= '<form action="newsinsert.php" method="post">';
	$tmprslt .= '<div class="row">';
	$tmprslt .= '<div class="col-md-12 col-sm-12 col-xs-12">';
	$tmprslt .= '<div class="form-group">';
	$tmprslt .= '<label for="title">Titel:</label>';
	$tmprslt .= '<input type="text" name="title" class="form-control" id="title" />';
	$tmprslt .= '</div>';
	$tmprslt .= '</div>';
	$tmprslt .= '</div>';
	$tmprslt .= 'Datum: ' . StrFTime ( '%d.%m.%Y %H:%M:%S', time () );
	$tmprslt .= '<div class="form-group">';
	$tmprslt .= '<label for="comment">Text:</label>';
	$tmprslt .= '<textarea name="message" rows="5" class="form-control" id="comment"></textarea>';
	$tmprslt .= '</div>';
	$tmprslt .= '<div class="checkbox">';
	$tmprslt .= 'Sichtbar?<input type="radio" name="visible" value="0" checked> ja <input type="radio" name="visible" value="-1"> nein';
	$tmprslt .= '</div>';
	$tmprslt .= '<div class="row">';
	$tmprslt .= '<div class="col-md-12 col-sm-12 col-xs-8">';
	$tmprslt .= '<button type="buttont" class="btn btn-success">Speichern</button>&nbsp';
	$tmprslt .= '<button type="buttont" class="btn btn-danger">Zurücksetzen</button>';
	$tmprslt .= '</div>';
	$tmprslt .= '</div>';
	$tmprslt .= '</form>';
	return $tmprslt;
}

/* Nachricht löschen */
function load_admin_newsdel($id)
{

	$tmprslt = '';
	$con = getDB();
	
	if ($con) {

		$sql = "SELECT title FROM news WHERE id = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="newsdel.php" method="post">';
			$tmprslt .= '<p>Möchten Sie die Nachricht <b>' . $news->title . '</b> wirklich löschen?</p>';
			$tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?uri=news\'"></p>';
			$tmprslt .= '<input type="hidden" name="id" value="' . $id . '">';
			$tmprslt .= '</form>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Gesamtübersicht der Downloads laden */
function load_admin_downloads()
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime, path, filename, visible FROM downloads ORDER BY datetime DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$tmprslt .= '<p><a href="$PHP_SELF?uri=downloadsadd" class="btn btn-primary" role="button">Download hinzufügen</a></p>';
			$tmprslt .= '<table class="table table-hover table-striped">';
			$tmprslt .= '<thead>';
			$tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Sichtbar?</th><th>Aktionen</th></tr>';
			$tmprslt .= '</thead>';
			$tmprslt .= '<tbody>';
			while ( $downloads = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', $downloads->datetime ) . "</td><td>$downloads->title</td><td>$downloads->path$downloads->filename</td><td>" . (($downloads->visible > - 1) ? 'ja' : 'nein') . "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=downloadsedit&id=$downloads->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=downloadsdel&id=$downloads->id\">Löschen</a></tr>";
			}
			$tmprslt .= '</tbody>';
			$tmprslt .= '</table>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Formular zum Bearbeiten eines Downloads laden */
function load_admin_downloadsedit($id)
{

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = 'SELECT id, title, comment, UNIX_TIMESTAMP(datetime) AS datetime, path, filename, visible FROM downloads ORDER BY datetime DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$downloads = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="downloadsupdate.php" method="post">';
			$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
			$tmprslt .= '<tr><th>ID:</th><td>' . $downloads->id . '<input type="hidden" name="id" value="' . $downloads->id . '"></td></tr>';
			$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="' . $downloads->title . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>Datum:</th><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', $downloads->datetime ) . '</td></tr>';
			$tmprslt .= '<tr><th>Pfad:</th><td><input type="text" name="path" value="' . $downloads->path . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>Dateiname:</th><td><input type="text" name="filename" value="' . $downloads->filename . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>Kommentar:</th><td><textarea name="comment" cols="64" rows="16">' . $downloads->comment . '</textarea></td></tr>';
			$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"' . (($downloads->visible > - 1) ? ' checked' : '') . '> ja <input type="radio" name="visible" value="-1"' . (($downloads->visible < 0) ? ' checked' : '') . '> nein</td></tr>';
			$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
			$tmprslt .= '</table>';
			$tmprslt .= '</form>';
		}
		mysqli_close ($con);
	}
	return $tmprslt;
}

/* Formular zum Erstellen eines Downloads laden */
function load_admin_downloadsadd($id)
{
	$tmprslt = '';
	$tmprslt .= '<form action="downloadsinsert.php" method="post">';
	$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
	$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="' . $downloads->title . '" size="64"></td></tr>';
	$tmprslt .= '<tr><th>Datum:</th><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', time () ) . '</td></tr>';
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

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = "SELECT title FROM downloads WHERE id = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="downloadsdel.php" method="post">';
			$tmprslt .= '<p>Möchten Sie den Download <b>' . $news->title . '</b> wirklich löschen?</p>';
			$tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?uri=downloads\'"></p>';
			$tmprslt .= '<input type="hidden" name="id" value="' . $id . '">';
			$tmprslt .= '</form>';
		}
		mysqli_close ($con);
	}
	return $tmprslt;
}

/* Gesamtübersicht der Links laden */
function load_admin_links()
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT id, title, uri, visible FROM links ORDER BY title DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$tmprslt .= '<p><a href="$PHP_SELF?uri=linkadd" class="btn btn-primary" role="button">Link hinzufügen</a></p>';
			$tmprslt .= '<table class="table table-hover table-striped">';
			$tmprslt .= '<thead>';
			$tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Sichtbar?</th><th>Aktionen</th></tr>';
			$tmprslt .= '</thead>';
			$tmprslt .= '<tbody>';
			while ( $links = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= "<tr><td>$links->title</td><td>$links->uri</td><td>" . (($links->visible > - 1) ? 'ja' : 'nein') . "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=linkedit&id=$links->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=linkdel&id=$links->id\">Löschen</a></tr>";
			}
			$tmprslt .= '</tbody>';
			$tmprslt .= '</table>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Formular zum Bearbeiten eines Links laden */
function load_admin_linkedit($id)
{

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = 'SELECT id, title, uri, comment, visible FROM links WHERE id = ' . $id;
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$links = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="linkupdate.php" method="post">';
			$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
			$tmprslt .= '<tr><th>ID:</th><td>' . $links->id . '<input type="hidden" name="id" value="' . $links->id . '"></td></tr>';
			$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="' . $links->title . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>URI:</th><td><input type="text" name="uri" value="' . $links->uri . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>Kommentar:</th><td><textarea name="comment" cols="64" rows="16">' . $links->comment . '</textarea></td></tr>';
			$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"' . (($links->visible > - 1) ? ' checked' : '') . '> ja <input type="radio" name="visible" value="-1"' . (($links->visible < 0) ? ' checked' : '') . '> nein</td></tr>';
			$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
			$tmprslt .= '</table>';
			$tmprslt .= '</form>';
		}
		mysqli_close ($con);
	}
	return $tmprslt;
}

/* Formular zum Erstellen einer Nachricht laden */
function load_admin_linkadd($id) {
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
function load_admin_linkdel($id) {

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = "SELECT title, uri FROM links WHERE id = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$links = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="linkdel.php" method="post">';
			$tmprslt .= '<p>Möchten Sie den Link <b>' . $links->title . ' (' . $links->uri . ')</b> wirklich löschen?</p>';
			$tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?uri=links\'"></p>';
			$tmprslt .= '<input type="hidden" name="id" value="' . $id . '">';
			$tmprslt .= '</form>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Gesamtübersicht der Artikel laden */
function load_admin_articles()
{

	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT id, title, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM articles ORDER BY datetime DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$tmprslt .= '<p><a href="$PHP_SELF?uri=articleadd" class="btn btn-primary" role="button">Artikel erstellen</a></p>';
			$tmprslt .= '<table class="table table-hover table-striped">';
			$tmprslt .= '<thead>';
			$tmprslt .= '<tr><th>Datum</th><th>Titel</th><th>Sichtbar?</th><th>Aktionen</th></tr>';
			$tmprslt .= '</thead>';
			$tmprslt .= '<tbody>';
			while ( $articles = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', $articles->datetime ) . "</td><td>$articles->title</td><td>" . (($articles->visible > - 1) ? 'ja' : 'nein') . "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=articleedit&id=$articles->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=articledel&id=$articles->id\">Löschen</a></tr>";
			}
			$tmprslt .= '</tbody>';
			$tmprslt .= '</table>';
		}
		mysqli_close ( $con );
	}
	return $tmprslt;
}

/* Formular zum Bearbeiten eines Artikels laden */
function load_admin_articleedit($id)
{
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT id, title, content, UNIX_TIMESTAMP(datetime) AS datetime, visible FROM articles WHERE id = ' . $id;
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$articles = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="articleupdate.php" method="post">';
			$tmprslt .= '<table width="100%" border="0" cellpadding="2" cellspacing="2">';
			$tmprslt .= '<tr><th>ID:</th><td>' . $articles->id . '<input type="hidden" name="id" value="' . $articles->id . '"></td></tr>';
			$tmprslt .= '<tr><th>Titel:</th><td><input type="text" name="title" value="' . $articles->title . '" size="64"></td></tr>';
			$tmprslt .= '<tr><th>Datum:</th><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', $articles->datetime ) . '</td></tr>';
			$tmprslt .= '<tr><th>Inhalt:</th><td><textarea name="content" cols="64" rows="16">' . $articles->content . '</textarea></td></tr>';
			$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0"' . (($articles->visible > - 1) ? ' checked' : '') . '> ja <input type="radio" name="visible" value="-1"' . (($articles->visible < 0) ? ' checked' : '') . '> nein</td></tr>';
			$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
			$tmprslt .= '</table>';
			$tmprslt .= '</form>';
		}
		mysqli_close ($con);
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
	$tmprslt .= '<tr><th>Datum:</th><td>' . StrFTime ( '%d.%m.%Y %H:%M:%S', time () ) . '</td></tr>';
	$tmprslt .= '<tr><th>Inhalt:</th><td><textarea name="content" cols="64" rows="16"></textarea></td></tr>';
	$tmprslt .= '<tr><th>Sichtbar?</th><td><input type="radio" name="visible" value="0" checked> ja <input type="radio" name="visible" value="-1"> nein</td></tr>';
	$tmprslt .= '<tr><td colspan="2"><input type="submit" value="Speichern"> <input type="reset" value="Zurücksetzen"></td></tr>';
	$tmprslt .= '</table>';
	$tmprslt .= '</form>';
	
	return $tmprslt;
}

/* Artikel löschen */
function load_admin_articledel($id) {
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		$sql = "SELECT title FROM articles WHERE id = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$articles = mysqli_fetch_object ( $result );
			$tmprslt .= '<form action="articledel.php" method="post">';
			$tmprslt .= '<p>Möchten Sie den Artikel <b>' . $articles->title . '</b> wirklich löschen?</p>';
			$tmprslt .= '<p><input type="submit" value="Ja"> <input type="reset" value="Nein" onClick="location.href = \'index.php?uri=articles\'"></p>';
			$tmprslt .= '<input type="hidden" name="id" value="' . $id . '">';
			$tmprslt .= '</form>';
		}
		mysqli_close ($con);
	}
	return $tmprslt;
}


