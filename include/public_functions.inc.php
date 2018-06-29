<?php

/*
 * *******************************************************************************
 * Contains all public functions for heinerCMS
 *
 * @author: Heinrich Schiller
 * @date: 2017-06-09
 * @licence: MIT
 *
 * content
 *
 * public section
 * *******************************************************************************
 */

/**
 * Get blog url for a extern blog
 * 
 * @return string
 */
function getBlogURL(): string
{
    return $_SESSION['blog-url'];
}

/**
 * Load navigation bar on public section
 * 
 * @return string
 */
function load_navigation(): string
{
    $blog = '';
    $news = '';
    $downloads = '';
    $links = '';
    $articles = '';

    if (! empty(getBlogURL())) {
        $blog .= '<a class="nav-item nav-link" href="' . getBlogURL() . '" target="blank">Blog</a>';
    }

    if (countTableEntries('news') !== 0) {
        $news .= ' <a class="nav-item nav-link" href="index.php?uri=news">Neuigkeiten</a>';
    }

    if (countTableEntries('downloads') !== 0) {
        $downloads .= '<a class="nav-item nav-link" href="index.php?uri=downloads">Downloads</a>';
    }

    if (countTableEntries('links') !== 0) {
        $links .= '<a class="nav-item nav-link" href="index.php?uri=links">Links</a>';
    }

    if (countTableEntries('articles') !== 0) {
        $articles .= '<a class="nav-item nav-link" href="index.php?uri=articles">Artikel</a>';
    }

    $placeholderList = [
        '##placeholder-title##'     => 'Heinrich-Schiller.de',
        '##placeholder-blog##'      => $blog,
        '##placeholder-news##'      => $news,
        '##placeholder-downloads##' => $downloads,
        '##placeholder-links##'     => $links,
        '##placeholder-articles##'  => $articles,
        '##placeholder-pages##'     => load_nav_pages()
    ];
    
    $template = loadTemplate('pub_navigation');

    return strtr($template, $placeholderList);
}

/**
 * 
 * @return string
 */
function load_nav_pages(): string
{
    $html = '';

    $pdo = getPdoConnection();

    $sql = "SELECT `id`, `title` FROM `sites` WHERE `visibility` = 0 AND `trash` = 'false'";

    try {

        $result = $pdo->query($sql);

        foreach ($result as $key) {
            $html .= '<a  class="nav-item nav-link" href="index.php?uri=pages&id=' . $key[0] . '">' . $key[1] . '</a>';
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
function load_news(): string
{
    $content = '';
    $placeholderList = [];

    $template = loadTemplate('pub_news');
    $templateNewsContent = loadTemplate('pub_news_content');

    $stmt = loadPublicNewsStatement();

    while ($news = $stmt->fetch(PDO::FETCH_OBJ)) {

        $placeholderList = [
            '##placeholder-news-page-tagline##' => $news->news_tagline,
            '##placeholder-news-page-comment##' => $news->news_comment
        ];

        $content .= load_news_content($news, $templateNewsContent);
    }

    $template = str_replace('##placeholder-news##', $content, $template);
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 * @param mixed $news
 * @param string $template
 * @return string
 */
function load_news_content($news, string $template) : string
{
    $placeholderList = [
        '##placeholder-news-datetime##' => StrFTime('%d.%m.%Y %H:%M', $news->datetime),
        '##placeholder-news-title##'    => $news->title,
        '##placeholder-news-id##'       => $news->id
    ];

    return strtr($template, $placeholderList);
}

/**
 * Detailansicht einer Nachricht laden
 *
 * @param int $id
 * @return string
 */
function load_news_detailed(int $id): string
{
    $content = '';
    $placeholderList = [];

    $stmt = loadNewsDetailedStatement($id);

    while ($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', $news->datetime),
            '##placeholder-title##'    => $news->title,
            '##placeholder-message##'  => $news->message
        ];
    }

    $template = loadTemplate('pub_news_detailed');

    return strtr($template, $placeholderList);
}

/**
 *
 * @return string
 */
function load_articles(): string
{
    $content = '';
    $placeholderList = [];

    $template = loadTemplate('pub_articles');
    $templateArticlesContent = loadTemplate('pub_articles_content');

    $stmt = loadPublicArticlesStatement();

    while ($articles = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-articles-page-tagline##' => $articles->tagline,
            '##placeholder-articles-page-comment##' => $articles->comment
        ];

        $content .= load_articles_content($articles, $templateArticlesContent);
    }

    $template = str_replace('##placeholder-articles##', $content, $template);
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 * @param mixed $articles
 * @param string $template
 * @return string
 */
function load_articles_content($articles, string $template) : string
{
    $placeholderList = [
        '##placeholder-articles-datetime##' => StrFTime('%d.%m.%Y %H:%M', $articles->datetime),
        '##placeholder-articles-title##'    => $articles->title,
        '##placeholder-articles-id##'       => $articles->id
    ];

    return strtr($template, $placeholderList);
}

/**
 * Detailansicht eines Artikels laden
 *
 * @param int $id
 * @return string
 */
function load_articles_detailed(int $id): string
{
    $placeholderList = [];

    $stmt = loadArticlesDetailedStatement($id);

    while ($articles = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', $articles->datetime),
            '##placeholder-title##'    => $articles->title,
            '##placeholder-message##'  => $articles->content
        ];
    }

    $template = loadTemplate('pub_articles_detailed');

    return strtr($template, $placeholderList);
}

/**
 * 
 * @return string
 */
function load_downloads(): string
{
    $content = '';
    $placeholderList = [];

    $template = loadTemplate('pub_downloads');
    $templateNewsContent = loadTemplate('pub_downloads_content');

    $stmt = loadPublicDownloadsStatement();

    while ($downloads = $stmt->fetch(PDO::FETCH_OBJ)) {

        $placeholderList = [
            '##placeholder-downloads-page-tagline##' => $downloads->downloads_tagline,
            '##placeholder-downloads-page-comment##' => $downloads->downloads_comment
        ];

        $content .= load_downloads_content($downloads, $templateNewsContent);
    }

    $template = str_replace('##placeholder-downloads##', $content, $template);
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 * @param mixed $downloads
 * @param string $template
 * @return string
 */
function load_downloads_content($downloads, string $template) : string
{
    $placeholderList = [
        '##placeholder-downloads-datetime##' => StrFTime('%d.%m.%Y %H:%M', $downloads->datetime),
        '##placeholder-downloads-title##'    => $downloads->title,
        '##placeholder-downloads-comment##'  => $downloads->comment,
        '##placeholder-downloads-path##'     => $downloads->path,
        '##placeholder-downloads-filename##' => $downloads->filename
    ];

    return strtr($template, $placeholderList);
}

/**
 * 
 * @return string
 */
function load_links(): string
{
    $content = '';
    $placeholderList = [];

    $template = loadTemplate('pub_links');
    $templateLinksContent = loadTemplate('pub_links_content');

    $stmt = loadPublicLinksStatement();

    while ($links = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-links-page-tagline##' => $links->settings_tagline,
            '##placeholder-links-page-comment##' => $links->settings_comment
        ];

        $content .= load_links_content($links, $templateLinksContent);
    }

    $template = str_replace('##placeholder-links##', $content, $template);
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 * @param mixed $links
 * @param string $template
 * @return string
 */
function load_links_content($links, string $template)
{
    $placeholderList = [
        '##placeholder-links-title##'   => $links->title,
        '##placeholder-links-tagline##' => $links->tagline,
        '##placeholder-links-uri##'     => $links->uri,
        '##placeholder-links-comment##' => $links->comment
    ];

    return strtr($template, $placeholderList);
}

/**
 * 
 * @param int $id
 * @return string
 */
function load_pages(int $id): string
{
    $template = '';

    $pdo = getPdoConnection();
    
    $sql = "SELECT `id`, `title`, `tagline`,`content` FROM `sites` WHERE `id` = :id";

    $input_parameters = [
        ':id' => $id
    ];

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);

        $site = $stmt->fetchObject();

        $placeholderList = [
            '##placeholder-title##' => $site->title,
            '##placeholder-tagline##' => $site->tagline,
            '##placeholder-content##' => $site->content
        ];

    } catch (PDOException $ex) {

        echo $ex->getMessage();
        exit();
    }

    $template = loadTemplate('pub_page');
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 */
function load_mainpage(): string
{
    $template = loadTemplate('pub_mainpage');
    
    $settings = getGeneralSettings();
    
    $placeholderList = [
        '##placeholder-title##' => $settings['title'],
        '##placeholder-tagline##' => $settings['tagline'],
        '##placeholder-card##' => load_cards()
    ];
    
    return strtr($template, $placeholderList);
}

/**
 * 
 * @return string
 */
function load_cards()
{
    $card = '';
    $template = loadTemplate('pub_card');
    
    $sql = "SELECT id, title, content, created_at, 
            (SELECT COUNT(id) FROM articles WHERE trash LIKE 'false' AND visibility = 0) as count
            FROM articles 
            WHERE trash like 'false' AND visibility = 0 ORDER By created_at DESC LIMIT 3";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($article['count'] == '1') {
            $columnNumber = 12;
        } else if ($article['count'] == '2') {
            $columnNumber = 6;
        } else {
            $columnNumber = 4;
        }
        
        $placeholderList = [
            '##placeholder-col-num##' => $columnNumber,
            '##placeholder-title##'   => $article['title'],
            '##placeholder-content##' => substr($article['content'], 0, 160)
        ];
        
        $card .= strtr($template, $placeholderList);
    }

    return $card;
}

/**
 * 
 * @param string $table
 * @return int
 */
function countTableEntries(string $table): int
{
    $id = 0;
    $pdo = getPdoConnection();

    $sql = "SELECT COUNT(`id`) FROM `$table` WHERE `trash` = 'false' AND `visibility` > -1";

    foreach ($pdo->query($sql) as $row) {
        $id = (int) $row[0];
    }

    return $id;
}
