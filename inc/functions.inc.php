<?php

/* ********************************************************************************
 * Contains all functions for heinerCMS
 * 
 * @author: Heinrich Schiller
 * @date: 2017-06-09
 * 
 * content
 * 
 * generic section
 * admin section
 * sql section
 * *******************************************************************************/

/* ********************************************************************************
 * generic - section
 * *******************************************************************************/
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

/**
 * Database adapter for MySQL
 * 
 * @return PDO
 */
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

function loadTemplate($template) {
	$file = __DIR__ . '/../templates/'. $_SESSION['theme'] . '/' . $template . '.tpl.php';

	if (file_exists($file)) {
		return file_get_contents($file);
	}

	return false;
}

function loadTemplateNewVersion($result,$template){

    $file = __DIR__ . '/../templates/bootstrap-3.3.7/'. $template . '.tpl.php';

    if (file_exists($file)){

        ob_start();
        
        include $file;
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
    }
    else {

        return 'could not find template';
    }  
    
}

function load_session()
{
    $config = __DIR__ . '/../source/configs/config.ini';
    
    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);
        
        $_SESSION['title'] = $ini_array['title'];
        $_SESSION['theme'] = $ini_array['theme'];
    }
}


/* Gesamtübersicht der Nachrichten laden */
function load_content_news()
{
	$template = '';
	$PHP_SELF = $_SERVER['PHP_SELF'];
	$con = getDB ();
	
	if ($con) {
		
		$sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `news` WHERE `visible` > -1 ORDER BY `datetime` DESC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $news = mysqli_fetch_object ( $result ) ) {
				$template .= StrFTime ( '%d.%m.%Y %H:%M', $news->datetime );
				$template .= " - <a href=\"$PHP_SELF?uri=newsdet&id=$news->id\">$news->title</a><br>\n";
			}
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Detailansicht einer Nachricht laden */
function load_content_newsdetailed($id)
{
	$template = '';
	$con = getDB ();
	if ($con) {
		
		$sql = "SELECT `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `news` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$news = mysqli_fetch_object ( $result );
			$template .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M', $news->datetime ) . "</h5>";
			$template .= "<h2>$news->title</h2>";
			$template .= "<p>$news->message</p>";
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Gesamtübersicht der Downloads laden */
function load_content_downloads()
{
	$template = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT `id`, `title` FROM `downloads` WHERE `visible` > -1 ORDER BY `title` ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $downloads = mysqli_fetch_object ( $result ) ) {
				$template .= '<a href="'.$_SERVER['PHP_SELF'].'?uri=downloadsdet&id='.$downloads->id.'"> - '.$downloads->title.'</a><br>';
			}
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Detailansicht eines Downloads laden */
function load_content_downloadsdetailed($id)
{
	$template = '';
	$con = getDB ();
	if ($con) {
		
		$sql = "SELECT `title`, `comment`, `path`, `filename`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `downloads` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$downloads = mysqli_fetch_object ( $result );
			$template .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M', $downloads->datetime ) . "</h5>";
			$template .= "<h2>$downloads->title</h2>";
			$template .= "<p>$downloads->comment</p>";
			$template .= "<p><a href=\"$downloads->path$downloads->filename\">Hier klicken!</a></p>";
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Gesamtübersicht der Artikel laden */
function load_content_articles()
{
	$template = '';
	$con = getDB ();
	
	if ($con) {
		
		$sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `articles` WHERE `visible` > -1 ORDER BY `datetime` ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $articles = mysqli_fetch_object ( $result ) ) {
				$template .= StrFTime ( '%d.%m.%Y %H:%M', $articles->datetime );
				$template .= '<a href="'.$_SERVER['PHP_SELF'].'?uri=articlesdet&id='.$articles->id.'\"> - '.$articles->title.'</a><br>';
			}
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Detailansicht eines Artikels laden */
function load_content_articlesdetailed($id)
{
	$template = '';
	$con = getDB ();
	if ($con) {
		
		$sql = "SELECT `title`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `articles` WHERE `id` = $id";
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			$articles = mysqli_fetch_object ( $result );
			$template .= "<h5>" . StrFTime ( '%d.%m.%Y %H:%M', $articles->datetime ) . "</h5>";
			$template .= "<h2>$articles->title</h2>";
			$template .= $articles->content;
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Gesamtübersicht der Links laden */
function load_content_links()
{
	$template = '';
	$con = getDB ();
	if ($con) {
		
		$sql = 'SELECT `title`, `uri`, `comment` FROM `links` WHERE `visible` > -1 ORDER BY `title` ASC';
		$result = mysqli_query ( $con, $sql );
		if ($result) {
			while ( $links = mysqli_fetch_object ( $result ) ) {
				$template .= "<p><a href=\"$links->uri\">$links->title</a><br>$links->comment<br><span class=\"uri\">$links->uri</span></p>";
			}
		}
		mysqli_close ( $con );
	}
	return $template;
}


/* ********************************************************************************
 * admin - section
 * *******************************************************************************/


function load_admin_navigation()
{
	$template = '';

	$template = loadTemplateNewVersion(countEntries(), 'adm_navigation');
	
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
			$template = loadTemplateNewVersion($result, 'adm_news');
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Formular zum Bearbeiten einer Nachricht laden */
function load_admin_newsedit($id)
{
	$template = '';

	$pdo = getPdoDB();

	$template = loadTemplateNewVersion(getOneNewsRecordById($id), 'adm_news_edit');
	
	return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
function load_admin_newsadd()
{
	$template = '';

	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );
	$template = loadTemplateNewVersion($time, 'adm_news_add');
	
	return $template;
}

/* Nachricht löschen */
function load_admin_newsdel($id)
{
    $template = '';
    $container = [];
    
    $title = getTitleFromTableById('news', $id);
    
    $container = [ 'id' => $id, 'title' => $title ];
    
    $template = loadTemplateNewVersion($container, 'adm_news_del');
    
	return $template;
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
	
	$con = getDB();
	
	if ($con) {

		$sql = "SELECT `id`, `title`, `comment`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible` FROM `downloads` WHERE `id`=$id";
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			$downloads = mysqli_fetch_object ( $result );
			
			$template = loadTemplateNewVersion($downloads, 'downloadsedit');
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
	$title = getTitleFromTableById('downloads', $id);
	
	$container = [ 'id' => $id, 'title' => $title ];
	
	$template = loadTemplateNewVersion($container, 'downloadsdel');
	
	return $template;
}

/* Gesamtübersicht der Links laden */
function load_admin_links()
{
    $template = '';
    
    $con = getDB ();
    
    if ($con) {
        
		$sql = "SELECT `id`, `title`, `uri`, `visible` FROM `links` WHERE `trash` = 'false' ORDER BY `title` DESC";
		
		if ($result = mysqli_query ( $con, $sql )) {
		    $template = loadTemplateNewVersion($result, 'adm_links');
		}
		
		mysqli_close ( $con );
	}
	
	return $template;
}

/* Formular zum Bearbeiten eines Links laden */
function load_admin_linkedit($id)
{

	$template = '';

	$result = getOneLinkRecordById($id);
	
	$template = loadTemplateNewVersion($result, 'adm_link_edit');

	return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
function load_admin_linkadd() {
	$template = '';

	$template = loadTemplate('adm_link_add');

	return $template;
}

/* Link löschen */
function load_admin_linkdel($id) {

	$template = '';
	$container= [];
	
	$title = getTitleFromTableById('links', $id);
	
	$container = [ 'id' => $id, 'title' => $title ];
	
	$template = loadTemplateNewVersion($container, 'adm_link_del');
	
	return $template;
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

	$result = getOneArticleRecordById($id);

	$template = loadTemplateNewVersion($result,'adm_article_edit');

	return $template;
}

/* Formular zum Erstellen eines Artikels laden */
function load_admin_articleadd($id)
{
	$template = '';

	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );
	
	$template = loadTemplateNewVersion($time, 'adm_article_add');
	
	return $template;
}

/* Artikel löschen */
function load_admin_articledel($id) {
    $template = '';
    $container = [];

	$title = getTitleFromTableById('articles', $id);
	
	$container = ['id' => $id, 'title' => $title];

	if ($container) {
        $template = loadTemplateNewVersion($container, 'articledel');
	}

	return $template;
}

function load_dashboard()
{
    $template = '';
    $content = [];

    $news = loadFromTable('news', 5);
    $articles = loadFromTable('articles', 5);
    $links = loadFromTable('links', 5);
    $downloads = loadFromTable('downloads', 5);

    $content = [$news, $downloads, $links, $articles];

    $template = loadTemplateNewVersion($content,'adm_dashboard');

    return $template;
}

function load_trash()
{
    $template = '';
    $content = [];

    $news = loadTrashFromTable('news');
    $downloads = loadTrashFromTable('downloads');
    $links = loadTrashFromTable('links');
    $artikles = loadTrashFromTable('articles');
    
    $content = [$news,$downloads,$links,$artikles];
    
    $template = loadTemplateNewVersion($content, 'adm_trash');
    
    return $template;
}


function load_general_settings()
{
    $template_dir = __DIR__ . '/../templates/';

    $tmp = scandir($template_dir);
    
    $template = loadTemplateNewVersion($tmp, 'adm_general_settings');
    
    return $template;
}

/* ********************************************************************************
 * SQL - section
 * *******************************************************************************/

/**
 * Count all Entries for navigation information
 * 
 * @return array
 */
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
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

/**
 * 
 * @param string $db
 * @param int $count
 * 
 * @return array
 */
function loadFromTable($table,$count)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `$table` WHERE `trash` = 'false' ORDER BY `created_at` DESC LIMIT $count";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return  $stmt->fetchAll();
}

/**
 * Get id, title and datetime from a table where trash-flag is true.
 * 
 * @param string $table
 * @return array
 */
function loadTrashFromTable($table)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `$table` WHERE `trash` = 'true' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return  $stmt->fetchAll();
}

/**
 * Get title from a table by id
 * 
 * @param string $table - Name of the Table
 * @param int $id - Id
 * 
 * @return string
 */
function getTitleFromTableById($table, $id)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `title` FROM `$table` WHERE `id` = $id";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    return $stmt->fetchColumn();
}


function getOneNewsRecordById($id)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `news` WHERE `id` = $id";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchObject();
}

function getAllLinks()
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, `uri`, `visible` FROM `links` WHERE `trash` = 'false' ORDER BY `title` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchAll();
}

function getOneArticleRecordById($id)
{
    $pdo = getPdoDB();

    $sql = "SELECT `id`, `title`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `articles` WHERE `id` = $id";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchObject();
}

function getAllArticles()
{
    $pdo = getPdoDB();

    $sql = "SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `articles` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchObject();
}

function getOneLinkRecordById($id)
{
    $pdo = getPdoDB();

    $sql = "SELECT `id`, `title`, `uri`, `comment`, `visible` FROM `links` WHERE `id` = $id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchObject();
}

/**
 * 
 * @param string $table
 */
function deleteAllTrashItems($table)
{
    $pdo = getPdoDB();

    $sql = "DELETE FROM `$table` WHERE `trash` = 'true'";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
}

/**
 * 
 * @param array $items
 * @param string $table
 */
function deleteItemsById($items, $table)
{
    $pdo = getPdoDB();
    
    $sql = "DELETE FROM `$table` WHERE `id` = '$items[0]'";
    array_shift($items);
    
    foreach ($items as $key => $value) {
        $sql .= " OR `id` = '$value'";
    }
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * 
 * @param int $id
 * @param string $table
 */
function setFlagTrashById($id, $table)
{
    $pdo = getPdoDB();
    
    $sql = "UPDATE `$table` SET `trash`='true' WHERE `id`= $id";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
