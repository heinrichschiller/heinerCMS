<?php

/**
 * Database adapter for mysql
 * 
 * @deprecated
 * @return object - mysqli
 */
function getDB()
{
    $config = __DIR__ . '/../source/configs/config.ini';
    
    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);
        
        $host = $ini_array['host'];
        $user = $ini_array['user'];
        $password = $ini_array['password'];
        $database = $ini_array['database'];
    }
	
	try {
		return mysqli_connect ( $host, $user, $password, $database );
	} catch ( Exception $ex ) {
		echo $ex->getMessage ();
		exit();
	}
}

function getPdoDB()
{
	$config = __DIR__ . '/../source/configs/config.ini';
	
	if (file_exists($config)) {
		$ini_array = parse_ini_file($config);
		
		$host = $ini_array['host'];
		$user = $ini_array['user'];
		$password = $ini_array['password'];
		$database = $ini_array['database'];
	}

	try {
		$pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

		return $pdo;

	} catch (PDOException $ex) {
		echo $ex->getMessage();
		exit();
	}
	
}

function countEntries()
{
	$pdo = getPdoDB();

	$sql = "SELECT COUNT(`id`) as result FROM `news` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `downloads` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `links` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `articles` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(*) as result
                FROM (
                SELECT `trash` FROM `articles`
                UNION ALL
                SELECT `trash` FROM `news`
                UNION ALL
                SELECT `trash` FROM `downloads`
                UNION ALL
                SELECT `trash` FROM `links`
                ) as subquery
                WHERE `trash` = 'true';";

	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

function loadTemplate($template) {
	$file = __DIR__ . '/../templates/'. $template . '.php';

	if (file_exists($file)) {
		return file_get_contents($file);
	}

	return false;
}

function loadTemplateNewVersion($result,$template){

    // Pfad zum Template erstellen & überprüfen ob das Template existiert.
    $file = __DIR__ . '/../templates/'. $template . '.php';
    
    if (file_exists($file)){
        // Der Output des Scripts wird n einen Buffer gespeichert, d.h.
        // nicht gleich ausgegeben.
        ob_start();
        
        // Das Template-File wird eingebunden und dessen Ausgabe in
        // $output gespeichert.
        include $file;
        $output = ob_get_contents();
        ob_end_clean();
        
        // Output zurückgeben.
        return $output;
    }
    else {
        // Template-File existiert nicht-> Fehlermeldung.
        return 'could not find template';
    }  
    
}

function loadFromDB($db,$count)
{
    $pdo = getPdoDB();

    $sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `$db` WHERE `trash` = 'false' ORDER BY `created_at` DESC LIMIT $count";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return  $stmt->fetchAll();
}

function loadTrashFromDB($db)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `$db` WHERE `trash` = 'true' ORDER BY `created_at` DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return  $stmt->fetchAll();
}

/* Gesamtübersicht der Nachrichten laden */
function load_content_news()
{
	$tmprslt = '';
	$PHP_SELF = $_SERVER['PHP_SELF'];
	$con = getDB ();
	
	if ($con) {
		
		$sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `news` WHERE `visible` > -1 ORDER BY `datetime` DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $news = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= StrFTime ( '%d.%m.%Y %H:%M', $news->datetime );
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
		
		$sql = "SELECT `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `news` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );
			$tmprslt .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M', $news->datetime ) . "</h5>";
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
		
		$sql = 'SELECT `id`, `title` FROM `downloads` WHERE `visible` > -1 ORDER BY `title` ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $downloads = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= '<a href="'.$_SERVER['PHP_SELF'].'?uri=downloadsdet&id='.$downloads->id.'"> - '.$downloads->title.'</a><br>';
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
		
		$sql = "SELECT `title`, `comment`, `path`, `filename`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `downloads` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$downloads = mysqli_fetch_object ( $result );
			$tmprslt .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M', $downloads->datetime ) . "</h5>";
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
		
		$sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `articles` WHERE `visible` > -1 ORDER BY `datetime` ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $articles = mysqli_fetch_object ( $result ) ) {
				$tmprslt .= StrFTime ( '%d.%m.%Y %H:%M', $articles->datetime );
				$tmprslt .= '<a href="'.$_SERVER['PHP_SELF'].'?uri=articlesdet&id='.$articles->id.'\"> - '.$articles->title.'</a><br>';
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
		
		$sql = "SELECT `title`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `articles` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$articles = mysqli_fetch_object ( $result );
			$tmprslt .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M', $articles->datetime ) . "</h5>";
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
		
		$sql = 'SELECT `title`, `uri`, `comment` FROM `links` WHERE `visible` > -1 ORDER BY `title` ASC';
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


function load_admin_navigation()
{
	$template = '';

	countEntries();

	$template = loadTemplateNewVersion(countEntries(), 'navigation');
	
	return $template;
}

/* Gesamtübersicht der Nachrichten laden */
function load_admin_news()
{
	$template = '';
	$table_content = '';

	$con = getDB ();

	if ($con) {
		
		$sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `news` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
		$result = mysqli_query ( $con, $sql );

		if ($result) {

			$template = loadTemplate('adm-news');

			while ( $news = mysqli_fetch_object ( $result ) ) {
				$table_content .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M', $news->datetime );
				$table_content .= "</td><td>$news->title</td><td>" . (($news->visible > - 1) ? 'ja' : 'nein');
				$table_content .= "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=newsedit&id=$news->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=newsdel&id=$news->id\">Löschen</a></tr>";
			}
			
			$template = str_replace('###table-content###', $table_content, $template);
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Formular zum Bearbeiten einer Nachricht laden */
function load_admin_newsedit($id)
{
	$template = '';
	$isNo = '';
	$isYes = '';

	$con = getDB();

	if ($con) {

		$sql = "SELECT `id`, `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `news` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );

			$time = strftime ( '%d.%m.%Y %H:%M', $news->datetime );

			if ( $news->visible > - 1 ) {
				$isYes = ' checked';
			}
			
			if ( $news->visible < 0 ) {
				$isNo = ' checked';
			}
			
			$template .= loadTemplate('newsedit');

			$template = str_replace('###news-id###', $news->id, $template);
			$template = str_replace('###news-title###', $news->title, $template);
			$template = str_replace('###time###', $time, $template);
			$template = str_replace('###news-message###', $news->message, $template);
			$template = str_replace('###chk_yes###', $isYes, $template);
			$template = str_replace('###chk_no###', $isNo, $template);
		}

		mysqli_close ( $con );
	}
	
	return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
function load_admin_newsadd()
{
	$template = '';

	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );
	$template .= loadTemplate('newsadd');

	$template = str_replace('###time###',$time,$template);
	
	return $template;
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

function deleteNewsListById($newsList)
{
    $pdo = getPdoDB();
    
    $sql = "DELETE FROM `news` WHERE `id` = '$newsList[0]'";
    array_shift($newsList);
    
    foreach ($newsList as $key => $value) {
        $sql .= " OR `id` = '$value'";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

function setNewsAsTrash($id)
{
    $pdo = getPdoDB();

    $sql = "UPDATE `news` SET `trash`='true' WHERE `id`= $id";
    
    $stmt = $pdo->prepare( $sql );
    $stmt->execute();
}

/* Gesamtübersicht der Downloads laden */
function load_admin_downloads()
{
	$template = '';
	$table_content = '';

	$con = getDB ();

	if ($con) {
		
	    $sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible` FROM `downloads` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			$template = loadTemplate('adm_downloads');

			while ( $downloads = mysqli_fetch_object ( $result ) ) {
				$table_content .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M', $downloads->datetime );
				$table_content .= "</td><td>$downloads->title</td><td>";
				$table_content .= (($downloads->visible > - 1) ? 'ja' : 'nein');
				$table_content .= "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=downloadsedit&id=$downloads->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=downloadsdel&id=$downloads->id\">Löschen</a></tr>";
			}
			
			$template = str_replace('###downloads-content###', $table_content, $template);
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Formular zum Bearbeiten eines Downloads laden */
function load_admin_downloadsedit($id)
{

	$template = '';
	$isNo = '';
	$isYes = '';
	
	$con = getDB();
	
	if ($con) {

		$sql = 'SELECT `id`, `title`, `comment`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible` FROM `downloads` ORDER BY `datetime` DESC';
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			$downloads = mysqli_fetch_object ( $result );
			
			$time = strftime ( '%d.%m.%Y %H:%M', $downloads->datetime );

			if ($downloads->visible > - 1) {
				$isYes = ' checked';
			}

			if ($downloads->visible < 0) {
				$isNo = ' checked';
			}

			$template = loadTemplate('downloadsedit');
			
			$template = str_replace('###downloads-id###', $downloads->id, $template);
			$template = str_replace('###downloads-title###', $downloads->title, $template);
			$template = str_replace('###time###', $time, $template);
			$template = str_replace('###downloads-path###', $downloads->path, $template);
			$template = str_replace('###downloads-filename###', $downloads->filename, $template);
			$template = str_replace('###downloads-comment###', $downloads->comment, $template);
			$template = str_replace('###chk_yes###', $isYes, $template);
			$template = str_replace('###chk_no###', $isNo, $template);
		}
		mysqli_close ($con);
	}
	return $template;
}

/* Formular zum Erstellen eines Downloads laden */
function load_admin_downloadsadd($template)
{
	$template = '';
	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );

	$template .= loadTemplate('downloadsadd');
	$template = str_replace('###time###',$time,$template);

	return $template;
}

/* Download löschen */
function load_admin_downloadsdel($id)
{

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = "SELECT `title` FROM `downloads` WHERE `id` = $id";
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
	$template = '';
	$table_content = '';

	$con = getDB ();

	if ($con) {
		
		$sql = 'SELECT `id`, `title`, `uri`, `visible` FROM `links` ORDER BY `title` DESC';
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			
			while ( $links = mysqli_fetch_object ( $result ) ) {
				$table_content .= "<tr><td>$links->title</td><td>$links->uri</td><td>";
				$table_content .= (($links->visible > - 1) ? 'ja' : 'nein');
				$table_content .= "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=linkedit&id=$links->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=linkdel&id=$links->id\">Löschen</a></tr>";
			}
			
			$template = loadTemplate('adm_links');
			
			$template = str_replace('###table-content###', $table_content, $template);
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Formular zum Bearbeiten eines Links laden */
function load_admin_linkedit($id)
{

	$template = '';
	$isNo = '';
	$isYes = '';

	$con = getDB();
	
	if ($con) {

		$sql = "SELECT `id`, `title`, `uri`, `comment`, `visible` FROM `links` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			$links = mysqli_fetch_object ( $result );

			if ($links->visible > - 1) {
				$isYes = ' checked';
			}
			
			if ($links->visible < 0) {
				$isNo = ' checked';
			}
			
			$template = loadTemplate('linkedit');

			$template = str_replace('###links-id###', $links->id, $template);
			$template = str_replace('###links-title###', $links->title, $template);
			$template = str_replace('###links-uri###', $links->uri, $template);
			$template = str_replace('###links-comment###', $links->comment, $template);
			$template = str_replace('###chk_yes###', $isYes, $template);
			$template = str_replace('###chk_no###', $isNo, $template);
		}
		mysqli_close ($con);
	}
	return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
function load_admin_linkadd() {
	$template = '';

	$template = loadTemplate('linkadd');

	return $template;
}

/* Link löschen */
function load_admin_linkdel($id) {

	$tmprslt = '';
	$con = getDB();
	if ($con) {

		$sql = "SELECT `title`, `uri` FROM `links` WHERE `id` = $id";
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

	$template = '';

	$con = getDB ();

	if ($con) {
		
		$sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `articles` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
		
		if ($result = mysqli_query ( $con, $sql )) {
			$template = loadTemplateNewVersion($result, 'adm_articles');
		}

		mysqli_close ( $con );
	}

	return $template;
}

/* Formular zum Bearbeiten eines Artikels laden */
function load_admin_articleedit($id)
{
	$template = '';

	$con = getDB ();

	if ($con) {
		
		$sql = "SELECT `id`, `title`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `articles` WHERE `id` = $id";

		if ($result = mysqli_query ( $con, $sql )) {
			$result = mysqli_fetch_assoc ( $result );

			$result['time'] = strftime ( '%d.%m.%Y %H:%M', $result['datetime'] );

			$template = loadTemplateNewVersion($result,'articleedit');
		}
		mysqli_close ($con);
	}
	return $template;
}

/* Formular zum Erstellen eines Artikels laden */
function load_admin_articleadd($id)
{
	$template = '';

	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );
	
	$template = loadTemplate('articleadd');
	$template = str_replace('###time###',$time,$template);
	
	return $template;
}

/* Artikel löschen */
function load_admin_articledel($id) {
	$tmprslt = '';
	$con = getDB ();
	if ($con) {
		$sql = "SELECT `title` FROM `articles` WHERE `id` = $id";
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

function load_dashboard()
{
    $template = '';
    $content = [];

    $news = loadFromDB('news', 5);
    $articles = loadFromDB('articles', 5);
    $links = loadFromDB('links', 5);
    $downloads = loadFromDB('downloads', 5);

    $content = [$news, $downloads, $links, $articles];

    $template = loadTemplateNewVersion($content,'dashboard');

    return $template;
}

function load_trash()
{
    $template = '';
    $content = [];

    $news = loadTrashFromDB('news');
    $downloads = loadTrashFromDB('downloads');
    $links = loadTrashFromDB('links');
    $artikles = loadTrashFromDB('articles');
    
    $content = [$news,$downloads,$links,$artikles];
    
    $template = loadTemplateNewVersion($content, 'trash');
    
    return $template;
}