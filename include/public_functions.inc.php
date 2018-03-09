<?php

/*
 * *******************************************************************************
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
 * ******************************************************************************
 */

/*
 * *******************************************************************************
 * generic - section
 * ******************************************************************************
 */

/**
 */
function getBlogURL(): string
{
    return $_SESSION['blog-url'];
}

function load_public_navigation(): string
{
    $template = '';
    
    $template .= '<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="$PHP_SELF?uri=mainpage"><@title@></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">';
    
    if (! empty(getBlogURL())) {
        $template .= ' <a class="nav-item nav-link" href="' . getBlogURL() . '" target="blank">Blog</a>';
    }
    
    if (countTableEntries('news') !== 0) {
        $template .= ' <a class="nav-item nav-link" href="$PHP_SELF?uri=news">Neuigkeiten</a>';
    }
    
    if (countTableEntries('downloads') !== 0) {
        $template .= '<a class="nav-item nav-link" href="$PHP_SELF?uri=downloads">Downloads</a>';
    }
    
    if (countTableEntries('links') !== 0) {
        $template .= '<a class="nav-item nav-link" href="$PHP_SELF?uri=links">Links</a>';
    }
    
    if (countTableEntries('articles') !== 0) {
        $template .= '<a class="nav-item nav-link" href="$PHP_SELF?uri=articles">Artikel</a>';
    }
    
    $template .= load_sites();
    
    $template .= '<ul class="nav justify-content-end">
                      <li class="nav-item">
                        <a class="nav nav-link" href="index.php?uri=admin">Sign in</a>
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

function load_sites(): string
{
    $html = '';
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT `id`, `title` FROM `sites`';
    
    try {
        
        $result = $pdo->query($sql);
        
        foreach ($result as $key) {
            $html .= '<a  class="nav-item nav-link" href="$PHP_SELF?uri=sites&id=' . $key[0] . '">' . $key[1] . '</a>';
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
function load_public_news(): string
{
    $template = '';
    $content = '';
    
    $template = loadTemplate('pub_news');
    $templateNewsContent = loadTemplate('pub_news_content');
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT news.id, news.title, news.message, UNIX_TIMESTAMP(news.created_at) AS datetime,' 
        . ' news_settings.tagline as news_tagline, news_settings.comment as news_comment' 
        . ' FROM `news`, `news_settings`'
        . " WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while ($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        
        $placeholderList = [
            '##placeholder-news-page-tagline##' => $news->news_tagline,
            '##placeholder-news-page-comment##' => $news->news_comment
        ];
        
        $content .= load_public_news_content($news, $templateNewsContent);
    }
    
    $template = str_replace('##placeholder-news##', $content, $template);
    $template = strtr($template, $placeholderList);
    
    return $template;
}

function load_public_news_content($news, $template)
{
    $placeholderList = [
        '##placeholder-news-datetime##' => StrFTime('%d.%m.%Y %H:%M', $news->datetime),
        '##placeholder-news-title##' => $news->title,
        '##placeholder-news-id##' => $news->id
    ];
    
    return strtr($template, $placeholderList);
}

/**
 * Detailansicht einer Nachricht laden
 *
 * @param int $id
 * @return string
 */
function load_public_news_detailed(int $id): string
{
    $content = '';
    
    $pdo = getPdoDB();
    
    $sql = "SELECT `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `news` WHERE `id` = :id";
    
    $inputParameters = [
        ':id' => $id
    ];
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($inputParameters);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while ($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', $news->datetime),
            '##placeholder-title##' => $news->title,
            '##placeholder-message##' => $news->message
        ];
    }
    
    $template = loadTemplate('pub_news_detailed');
    
    return strtr($template, $placeholderList);
}

/**
 *
 * @return string
 */
function load_public_articles(): string
{
    $template = '';
    $content = '';
    
    $template = loadTemplate('pub_articles');
    $templateArticlesContent = loadTemplate('pub_articles_content');
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT articles.id, articles.title, articles.content, UNIX_TIMESTAMP(articles.created_at) AS datetime,' 
        . ' articles_settings.tagline as tagline, articles_settings.comment as comment' 
        . ' FROM `articles`, `articles_settings`' 
        . " WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while ($articles = $stmt->fetch(PDO::FETCH_OBJ)) {
        
        $placeholderList = [
            '##placeholder-articles-page-tagline##' => $articles->tagline,
            '##placeholder-articles-page-comment##' => $articles->comment
        ];
        
        $content .= load_public_articles_content($articles, $templateArticlesContent);
    }

    $template = str_replace('##placeholder-articles##', $content, $template);
    $template = strtr($template, $placeholderList);
    
    return $template;
}

function load_public_articles_content($articles, $template)
{
    $placeholderList = [
        '##placeholder-articles-datetime##' => StrFTime('%d.%m.%Y %H:%M', $articles->datetime),
        '##placeholder-articles-title##' => $articles->title,
        '##placeholder-articles-id##' => $articles->id
    ];
    
    return strtr($template, $placeholderList);
}

/**
 * Detailansicht eines Artikels laden
 *
 * @param int $id
 * @return string
 */
function load_public_articles_detailed(int $id): string
{
    $content = '';
    
    $pdo = getPdoDB();
    
    $sql = "SELECT `title`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime FROM `articles` WHERE `id` = :id";
    
    $inputParameters = [
        ':id' => $id
    ];
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($inputParameters);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while ($articles = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', $articles->datetime),
            '##placeholder-title##' => $articles->title,
            '##placeholder-message##' => $articles->content
        ];
    }
    
    $template = loadTemplate('pub_articles_detailed');
    
    return strtr($template, $placeholderList);
}

function load_public_downloads(): string
{
    return loadTemplate('pub_downloads');
}

function load_public_links(): string
{
    $content = '';
    
    $template = loadTemplate('pub_links');
    $templateLinksContent = loadTemplate('pub_links_content');
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT links.title, links.tagline, links.uri, links.comment, UNIX_TIMESTAMP(links.created_at) AS datetime,' 
        . ' links_settings.tagline as settings_tagline, links_settings.comment as settings_comment' 
        . ' FROM `links`, `links_settings`' 
        . " WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while ($links = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-links-page-tagline##' => $links->settings_tagline,
            '##placeholder-links-page-comment##' => $links->settings_comment
        ];
        
        $content .= load_public_links_content($links, $templateLinksContent);
    }
    
    $template = str_replace('##placeholder-links##', $content, $template);
    $template = strtr($template, $placeholderList);
    
    return $template;
}

function load_public_links_content($links, $template)
{
    $placeholderList = [
        '##placeholder-links-title##' => $links->title,
        '##placeholder-links-tagline##' => $links->tagline,
        '##placeholder-links-uri##' => $links->uri,
        '##placeholder-links-comment##' => $links->comment
    ];
    
    return strtr($template, $placeholderList);
}

function load_public_sites(int $id): string
{
    $template = '';
    
    $pdo = getPdoDB();
    
    $sql = "SELECT `id`, `title`, `tagline`,`content` FROM `sites` WHERE `id` = :id";
    
    $input_parameters = [
        ':id' => $id
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
        $site = $stmt->fetchObject();
        
        $placeholderList = [
            '<@placeholder-title@>' => $site->title,
            '<@placeholder-tagline@>' => $site->tagline,
            '<@placeholder-content@>' => $site->content
        ];
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
    }
    
    $template = loadTemplate('pub_site');
    $template = strtr($template, $placeholderList);
    
    return $template;
}

function load_public_mainpage(): string
{
    return loadTemplate('pub_mainpage');
}

function countTableEntries(string $table): int
{
    $id = 0;
    $pdo = getPdoDB();
    
    $sql = "SELECT COUNT(`id`) FROM `$table` WHERE `trash` = 'false'";
    
    foreach ($pdo->query($sql) as $row) {
        $id = (int) $row[0];
    }
    
    return $id;
}


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
