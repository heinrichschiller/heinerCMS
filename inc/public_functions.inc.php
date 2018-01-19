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
 * *******************************************************************************


/**
 */
function getBlogURL() : string
{
    $config = __DIR__ . '/../source/configs/config.ini';
    
    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);
        
        return $ini_array['blog_url'];
    } else {
        echo 'url not found.';
        exit();
    }
}

function load_public_navigation() : string
{
    $template = '';
    
    $arr = [
        '<@url@>' => getBlogURL()
    ];
    
    $template = strtr(loadTemplate('pub_navigation'), $arr);
    
    return $template;
}

function load_public_news() : string
{
    return loadTemplate('pub_news');
}

function load_public_articles() : string
{
    return loadTemplate('pub_articles');
}

function load_public_downloads() : string
{
    return  loadTemplate('pub_downloads');
}

function load_public_links() : string
{
    return  loadTemplate('pub_links');
}

/* Gesamtübersicht der Nachrichten laden */
/**
 * 
 * @return string
 *
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
}*/

/* Detailansicht einer Nachricht laden */
/**
 * 
 * @param int $id
 * @return string
 *
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
}*/

/* Gesamtübersicht der Downloads laden */
/**
 * 
 * @return string
 *
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
}*/

/* Detailansicht eines Downloads laden */
/**
 * 
 * @param int $id
 * @return string
 *
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
}*/

/* Gesamtübersicht der Artikel laden */
/**
 * 
 * @return string
 *
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
}*/

/* Detailansicht eines Artikels laden */
/**
 * 
 * @param int $id
 * @return string
 *
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
}*/

/* Gesamtübersicht der Links laden */
/**
 * 
 * @return string
 *
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
}*/
