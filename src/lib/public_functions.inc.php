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
 * Load navigation bar on public section
 * 
 * @return string
 */
function load_navigation(): string
{
    $blog = '';
    $downloads = '';
    $links = '';
    $articles = '';

    $settings = getGeneralSettings();

    if (! empty($settings['blog_url'])) {
        $blog .= '<a class="nav-item nav-link" href="' . $settings['blog_url'] . '" target="blank">Blog</a>';
    }

    if (countContentType('download') !== 0) {
        $downloads .= '<a class="nav-item nav-link" href="index.php?uri=downloads">Downloads</a>';
    }

    if (countContentType('link') !== 0) {
        $links .= '<a class="nav-item nav-link" href="index.php?uri=links">Links</a>';
    }

    if (countContentType('article') !== 0) {
        $articles .= '<a class="nav-item nav-link" href="index.php?uri=articles">Artikel</a>';
    }

    $placeholderList = [
        '##placeholder-title##'     => $settings['title'],
        '##placeholder-blog##'      => $blog,
        '##placeholder-downloads##' => $downloads,
        '##placeholder-links##'     => $links,
        '##placeholder-articles##'  => $articles,
        '##placeholder-pages##'     => load_nav_pages()
    ];
    
    $template = getTemplate('pub_navigation');

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

    $sql = "
    SELECT `id`, 
        `title` 
        FROM `contents` 
        WHERE `content_type` = 'page' 
            AND `visibility` = 'true' 
            AND `flag` != 'trash'
    ";

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

function renderArticlesPage(): string
{
    $articlesPage = renderArticlePage();
    $articlesContent = renderArticlesContent();
    
    return str_replace('##placeholder-articles##', $articlesContent, $articlesPage);
}

/**
 *
 * @return string
 */
function renderArticlesContent(): string
{
    $content = '';
    $placeholderList = [];

    $template = getTemplate('pub_articles_content');

    $stmt = loadPublicArticlesStatement();

    while ($articles = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $placeholderList = [
            '##placeholder-articles-id##' => $articles['id'],
            '##placeholder-datetime##' => StrFTime('%d.%m.%Y', $articles['datetime']),
            '##placeholder-title##' => $articles['title'],
            '##placeholder-text##' => cutString($articles['text'])
        ];

        $content .= strtr($template, $placeholderList);
    }

    return strtr($content, $placeholderList);
}

function renderArticlePage() : string
{
    $settings = getArticleSettings();
    
    $placeholderList = [
        '##placeholder-articles-page-tagline##' => $settings['tagline'],
        '##placeholder-articles-page-comment##' => $settings['text']
    ];
    
    $template = getTemplate('pub_articles');
    
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

    $articleItems = getArticleDetailed($id);

    $placeholderList = [
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', $articleItems['datetime']),
        '##placeholder-title##'    => $articleItems['title'],
        '##placeholder-message##'  => $articleItems['text']
    ];

    $template = getTemplate('pub_articles_detailed');

    return strtr($template, $placeholderList);
}

function renderCurrentArticle()
{
    $template = getTemplate('pub_no_articles');
    
    if (countContentType('article') > 0) {
        $article = getCurrentArticle();
        
        $placeholder = [
            '##placeholder-id##'      => $article['id'],
            '##placeholder-title##'   => $article['title'],
            '##placeholder-content##' => cutString($article['text'], 2000)
        ];
        
        $template = getTemplate('pub_article_mainpage_content');
        $template = strtr($template, $placeholder);
    }
    
    
    return $template;
}

/**
 * 
 * @return string
 */
function load_downloads(): string
{
    $content = '';
    $placeholderList = [];

    $template = getTemplate('pub_downloads');
    $templateNewsContent = getTemplate('pub_downloads_content');

    $stmt = loadPublicDownloadsStatement();

    while ($downloads = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        $placeholderList = [
            '##placeholder-downloads-page-tagline##' => $downloads['downloads_tagline'],
            '##placeholder-downloads-page-comment##' => $downloads['downloads_text']
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
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', $downloads['datetime']),
        '##placeholder-title##'    => $downloads['title'],
        '##placeholder-comment##'  => $downloads['text'],
        '##placeholder-path##'     => $downloads['path'],
        '##placeholder-filename##' => $downloads['filename']
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

    $template = getTemplate('pub_links');
    $templateLinksContent = getTemplate('pub_links_content');

    $stmt = loadPublicLinksStatement();

    while ($links = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $placeholderList = [
            '##placeholder-links-page-tagline##' => $links['settings_tagline'],
            '##placeholder-links-page-comment##' => $links['settings_comment']
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
        '##placeholder-links-title##'   => $links['title'],
        '##placeholder-links-tagline##' => $links['tagline'],
        '##placeholder-links-uri##'     => $links['uri'],
        '##placeholder-links-comment##' => $links['text']
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
    $page = getPage($id);
    
    $placeholderList = [
        '##placeholder-title##'   => $page['title'],
        '##placeholder-tagline##' => $page['tagline'],
        '##placeholder-content##' => $page['text']
    ];

    $template = getTemplate('pub_page');
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 */
function load_mainpage(): string
{
    $settings = getGeneralSettings();
    $aboutme = getInfobox();
    
    $placeholderList = [
        '##placeholder-title##'           => $settings['title'],
        '##placeholder-tagline##'         => $settings['tagline'],
        '##placeholder-card##'            => '',
        '##placeholder-articles##'        => renderCurrentArticle(),
        '##placeholder-aboutme-title##'   => $aboutme['title'],
        '##placeholder-aboutme-content##' => $aboutme['text'],
    ];
    
    $template = getTemplate('pub_mainpage');
    return strtr($template, $placeholderList);
}

/**
 * 
 * @return string
 */
function load_cards()
{
    $card = '';
    $template = getTemplate('pub_card');
    
    $sql = "
    SELECT id, 
        title, 
        content, 
        created_at, 
            (SELECT COUNT(id) 
            FROM articles 
            WHERE trash LIKE 'false' 
                AND visibility = 0) as count
        FROM articles 
        WHERE trash like 'false' 
            AND visibility = 0 
            ORDER By created_at DESC LIMIT 3
    ";
    
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
 * To cut a string.
 * 
 * @param string $string
 * @return string
 * 
 * @since 0.8.0
 * 
 * @todo replace the third static parameter with the dynamic parameter
 * from the article settings
 */
function cutString(string $string, $length = 500)
{
    return substr($string, 0, $length);
}