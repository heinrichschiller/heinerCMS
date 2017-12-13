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

/**
 * 
 * @param string $template
 * @return string
 */
function loadTemplate(string $template) : string 
{
	$file = __DIR__ . '/../templates/'. $_SESSION['theme'] . '/' . $template . '.tpl.php';

	if (file_exists($file)) {
		return file_get_contents($file);
	}

	return 'Could not found template';
}

/**
 * @deprecated
 * @param unknown $result
 * @param unknown $template
 * @return string
 */
function loadTemplateNewVersion($result,$template) : string
{

    $file = __DIR__ . '/../templates/'. $_SESSION['theme'] . '/'. $template . '.tpl.php';

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

/**
 * 
 */
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
/**
 * 
 * @return string
 */
function load_content_news() : string
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
/**
 * 
 * @param int $id
 * @return string
 */
function load_content_newsdetailed(int $id) : string
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
/**
 * 
 * @return string
 */
function load_content_downloads() : string
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
/**
 * 
 * @param int $id
 * @return string
 */
function load_content_downloadsdetailed(int $id) : string
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
/**
 * 
 * @return string
 */
function load_content_articles() : string
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
/**
 * 
 * @param int $id
 * @return string
 */
function load_content_articlesdetailed(int $id) : string
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
/**
 * 
 * @return string
 */
function load_content_links() : string
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

/**
 * 
 * @return string
 */
function load_admin_navigation() : string
{
	$template = '';

	$template = loadTemplateNewVersion(countEntries(), 'adm_navigation');
	
	return $template;
}

/* Gesamtübersicht der Nachrichten laden */
/**
 * 
 * @return string
 */
function load_admin_news() : string
{
	$template = '';
	$table_content = '';

	$con = getDB ();

	if ($con) {
		
		$sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`'
		    . " FROM `news` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			$template = loadTemplateNewVersion($result, 'adm_news');
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Formular zum Bearbeiten einer Nachricht laden */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_newsedit(int $id) : string
{
	$template = '';

	$pdo = getPdoDB();

	$template = loadTemplateNewVersion(getOneNewsRecordById($id), 'adm_news_edit');
	
	return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
/**
 * 
 * @return string
 */
function load_admin_newsadd() : string
{
	$template = '';

	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );
	$template = loadTemplateNewVersion($time, 'adm_news_add');
	
	return $template;
}

/* Nachricht löschen */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_newsdel(int $id) : string
{
    $template = '';
    $container = [];
    
    $title = getTitleFromTableById('news', $id);
    
    $container = [ 'id' => $id, 'title' => $title ];
    
    $template = loadTemplateNewVersion($container, 'adm_news_del');
    
	return $template;
}

/* Gesamtübersicht der Downloads laden */
/**
 * 
 * @return string
 */
function load_admin_downloads() : string
{
	$template = '';
	$table_content = '';

	$con = getDB ();

	if ($con) {
		
	    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible`'
	        . " FROM `downloads` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
		$result = mysqli_query ( $con, $sql );

		if ($result) {
			$template = loadTemplate('adm_downloads');

			while ( $downloads = mysqli_fetch_object ( $result ) ) {
				$table_content .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M', $downloads->datetime );
				$table_content .= "</td><td>$downloads->title</td><td>";
				$table_content .= (($downloads->visible > - 1) ? 'ja' : 'nein');
				$table_content .= "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=downloadsedit&id=$downloads->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=downloadsdel&id=$downloads->id\">Löschen</a></tr>";
			}
			
			$template = str_replace('<@downloads-content@>', $table_content, $template);
		}
		mysqli_close ( $con );
	}
	return $template;
}

/* Formular zum Bearbeiten eines Downloads laden */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_downloadsedit(int $id) : string
{

	$template = '';
	
	$con = getDB();
	
	if ($con) {

		$sql = 'SELECT `id`, `title`, `comment`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible`'
		    . " FROM `downloads` WHERE `id`=$id";
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
/**
 * 
 * @return string
 */
function load_admin_downloadsadd() : string
{
	$template = '';
	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );

	$template .= loadTemplate('adm_downloads_add');
	$template = str_replace('###time###',$time,$template);

	return $template;
}

/* Download löschen */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_downloadsdel(int $id) : string
{
	$title = getTitleFromTableById('downloads', $id);
	
	$container = [ 'id' => $id, 'title' => $title ];
	
	$template = loadTemplateNewVersion($container, 'adm_downloads_del');
	
	return $template;
}

/* Gesamtübersicht der Links laden */
/**
 * 
 * @return string
 */
function load_admin_links() : string
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
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_linkedit(int $id) : string
{

	$template = '';

	$result = getOneLinkRecordById($id);
	
	$template = loadTemplateNewVersion($result, 'adm_link_edit');

	return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
/**
 * 
 * @return string
 */
function load_admin_linkadd() : string 
{
	$template = '';

	$template = loadTemplate('adm_link_add');

	return $template;
}

/* Link löschen */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_linkdel(int $id) : string {

	$template = '';
	$container= [];
	
	$title = getTitleFromTableById('links', $id);
	
	$container = [ 'id' => $id, 'title' => $title ];
	
	$template = loadTemplateNewVersion($container, 'adm_link_del');
	
	return $template;
}

/* Gesamtübersicht der Artikel laden */
/**
 * 
 * @return string
 */
function load_admin_articles() : string
{
	$template = '';

	$con = getDB ();

	if ($con) {
		
		$sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`'
		    . " FROM `articles` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
		
		if ($result = mysqli_query ( $con, $sql )) {
			$template = loadTemplateNewVersion($result, 'adm_articles');
		}

		mysqli_close ( $con );
	}

	return $template;
}

/* Formular zum Bearbeiten eines Artikels laden */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_articleedit(int $id) : string
{
	$template = '';

	$result = getOneArticleRecordById($id);

	$template = loadTemplateNewVersion($result,'adm_article_edit');

	return $template;
}

/* Formular zum Erstellen eines Artikels laden */
/**
 * 
 * @return string
 */
function load_admin_articleadd() : string
{
	$template = '';

	$time = StrFTime ( '%d.%m.%Y %H:%M', time () );
	
	$template = loadTemplateNewVersion($time, 'adm_article_add');
	
	return $template;
}

/* Artikel löschen */
/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_articledel(int $id) : string
{
    $template = '';
    $container = [];

	$title = getTitleFromTableById('articles', $id);
	
	$container = ['id' => $id, 'title' => $title];

	if ($container) {
        $template = loadTemplateNewVersion($container, 'adm_article_del');
	}

	return $template;
}

/**
 * 
 * @return string
 */
function load_dashboard() : string
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

/**
 * 
 * @return string
 */
function load_trash() : string
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

/**
 * 
 * @return string
 */
function load_general_settings() : string
{
    $template_dir = __DIR__ . '/../templates/';

    $tmp = scandir($template_dir);
    
    $template = loadTemplateNewVersion($tmp, 'adm_general_settings');
    
    return $template;
}

/**
 * 
 * @return string
 */
function load_user_list() : string
{
    $template = '';
    $table_content = '';
    
    $con = getDB ();
    
    if ($con) {
        
        $sql = 'SELECT `id`,`firstname`,`lastname`,`username`,`active`'
            . ' FROM `users` ORDER BY `firstname` DESC';
        $result = mysqli_query ( $con, $sql );
        
        if ($result) {
            $template = loadTemplate('adm_user_list');
            
            while ( $user = mysqli_fetch_object ( $result ) ) {
                $table_content .= '<tr><td>' . $user->id . '</td>';
                $table_content .= '<td>' . $user->firstname .'</td>';
                $table_content .= '<td>' . $user->lastname . '</td>';
                $table_content .= '<td>' . $user->username . '</td>';
                $table_content .= '<td>' . $user->active . '</td>';
                $table_content .= "<td><a href=\"$_SERVER[PHP_SELF]?uri=useredit&id=$user->id\">"
                    . "<span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\" title=\"Edit\"></span></a> &middot;"
                    . " <a href=\"$_SERVER[PHP_SELF]?uri=userdel&id=$user->id\">"
                        . "<span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></a></td></tr>";
                
            }
            
            $template = str_replace('<@user_list_content@>', $table_content, $template);
        }
        mysqli_close ( $con );
    }
    return $template;
}

/**
 * 
 * @param int $id
 * @return string
 */
function load_user_edit(int $id) : string
{
    $template = '';
    
    $template = loadTemplate('adm_user_edit');
    
    $user = getUserDataById($id);

    $arr = [
      '<@id@>' => $user['id'],
      '<@datetime@>' => '',
      '<@firstname@>' => $user['firstname'],
      '<@lastname@>' => $user['lastname'],
      '<@username@>' => $user['username'],
      '<@email@>' => $user['email'],
      '<@public_as@>' => $user['username']
    ];
    
    $template = strtr($template, $arr);
    
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
function loadFromTable(string $table, int $count)
{
    $pdo = getPdoDB();
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`'
        . " FROM `$table` WHERE `trash` = 'false' ORDER BY `created_at` DESC LIMIT $count";

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
function loadTrashFromTable(string $table)
{
    $pdo = getPdoDB();
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime'
        . " FROM `$table` WHERE `trash` = 'true' ORDER BY `created_at` DESC";
    
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
function getTitleFromTableById(string $table, int $id)
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


/**
 * 
 * @param int $id
 * @return mixed
 */
function getOneNewsRecordById(int $id)
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

/**
 * 
 * @return array
 */
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

/**
 * 
 * @param int $id
 * @return mixed
 */
function getOneArticleRecordById(int $id)
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

/**
 * 
 * @return mixed
 */
function getAllArticles()
{
    $pdo = getPdoDB();

    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`'
        . " FROM `articles` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
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
 * @param int $id
 * @return mixed
 */
function getOneLinkRecordById(int $id)
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
function deleteAllTrashItems(string $table)
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
function deleteItemsById(array $items, string $table)
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
function setFlagTrashById(int $id, string $table)
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

/**
 * 
 * @param int $id
 * @return mixed
 */
function getUserDataById(int $id)
{
    $pdo = getPdoDB();
        
    $sql = 'SELECT `id`,`firstname`,`lastname`,`email`,`password`,`created_at`,`updated_at`,`username`,`active`'
        . ' FROM `users`'
        . " WHERE `id` = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
            
    return $stmt->fetch();
}
