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
 
    $template .= '<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><@title@></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="<@url@>" target="blank">Blog</a>';
    
    if ( countTableEntries('news') !== 0) {
        $template .= ' <a class="nav-item nav-link" href="$PHP_SELF?uri=news">News</a>';
    }
    
    if ( countTableEntries('downloads') !== 0) {
        $template .= '<a class="nav-item nav-link" href="$PHP_SELF?uri=downloads">Downloads</a>';
    }
    
    if ( countTableEntries('links') !== 0) {
        $template .= '<a class="nav-item nav-link" href="$PHP_SELF?uri=links">Links</a>';
    }
    
    if ( countTableEntries('articles') !== 0) {
        $template .= '<a class="nav-item nav-link" href="$PHP_SELF?uri=articles">Artikel</a>';
    }

    $template .= load_sites();
    
    $template .= '<ul class="nav justify-content-end">
                      <li class="nav-item">
                        <a class="nav nav-link" href="?uri=admin">Sign in</a>
                      </li>
                  </ul>
            </div>
          </div>
        </nav>';
    
    $arr = [
        '<@title@>' => 'Heinrich-Schiller.de',
        '<@url@>' => getBlogURL()
    ];
    
    $template = strtr($template, $arr);
    
    return $template;
}

function load_sites() : string
{
    $html = '';
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT `id`, `title` FROM `sites`';
    
    try {
        
        $result = $pdo->query($sql);
        
        foreach ($result as $key) {
            $html .= '<a  class="nav-item nav-link" href="$PHP_SELF?uri=sites&id='.$key[0].'">'.$key[1].'</a>';
        }
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    return $html;
}

/**
 * 
 * @return string
 */
function load_public_news() : string
{
    $template = '';
    $table_content = '';
    
    $PHP_SELF = $_SERVER['PHP_SELF'];
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime'
        . " FROM `news` WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= StrFTime ( '%d.%m.%Y %H:%M', $news->datetime );
        $table_content .= " - <a href=\"$PHP_SELF?uri=newsdet&id=$news->id\">$news->title</a><br>\n";
    }
    
    $template = loadTemplate('pub_news');
    
    $template = str_replace('<@news@>', $table_content, $template);
    
    return $template;
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

function load_public_sites(int $id) : string
{
    $template = '';
    
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, `content` FROM `sites` WHERE `id` = :id";
    
    $input_parameters = [
        ':id' => $id
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
        $site = $stmt->fetchObject();

        $placeholderList = [
            '<@placeholder-title@>' => $site->title,
            '<@placeholder-content@>' => $site->content
        ];

    } catch(PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }

    $template = loadTemplate('pub_site');
    $template = strtr($template,$placeholderList);
    
    return $template;
}

function countTableEntries(string $table) : int
{
    $id = 0;
    $pdo = getPdoDB();
    
    $sql = "SELECT COUNT(`id`) FROM `$table` WHERE `trash` = 'false'";
    
    foreach ($pdo->query($sql) as $row) {
        $id = (int) $row[0];
    }
    
    return $id;
}
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
