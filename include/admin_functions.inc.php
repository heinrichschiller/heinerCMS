<?php

/**
 * Load the admin navigation with badges
 * 
 * @return string
 */
function load_navigation(): string
{
    $template = '';
    
    $entries = countEntries();
    
    $placeholderList = [
        '##placeholder-news##'      => $entries[0],
        '##placeholder-downloads##' => $entries[1],
        '##placeholder-links##'     => $entries[2],
        '##placeholder-articles##'  => $entries[3],
        '##placeholder-pages##'     => $entries[4],
        '##placeholder-trash##'     => $entries[5]
    ];
    
    $template = loadTemplate('adm_navigation');
    
    return strtr($template, $placeholderList);
}

/**
 * Load the admin sidebar.
 * 
 * @return string
 */
function load_sidebar(): string
{
    $template = '';
    
    $template = loadTemplate('adm_sidebar');
    
    return $template;
}

/**
 * Load general overview of all news entries.
 *
 * @return string
 */
function load_news(): string
{
    $content = '';
    
    $hasEntry = false;
    
    $stmt = loadNewsStatement();
    
    while ($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $content .= '<tr>';
        $content .= '<td>' . $news->id . '</td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $news->datetime) . '</td>';
        $content .= '<td>' . $news->title . '</td>';
        $content .= $news->visibility > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $content .= '<td>';
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" . $news->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" . $news->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsdel&id=" . $news->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a>';
        
        $content .= '</td>';
        $content .= '</tr>';
        
        $hasEntry = true;
    }

    if($hasEntry) {
        $template = loadTemplate('adm_news');
    } else {
        $template = loadTemplate('adm_no_entry');
    }

    $tplNewsEntries = loadTemplate('adm_news_entries');
    $tplNewsEntries = str_replace('##placeholder-table-content##', $content, $tplNewsEntries);
    
    return str_replace('##placeholder-content##', $tplNewsEntries, $template);
}

/**
 * Loading a form to edit a news entry.
 *
 * @param int $id Id of a news
 * @return string
 */
function load_news_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';

    $result = loadNewsEditStatement($id);
    
    if ($result->visibility > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'       => $result->id,
        '##placeholder-title##'    => $result->title,
        '##placeholder-message##'  => $result->message,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $result->datetime),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = loadTemplate('adm_news_edit');
    
    return strtr($template, $placeholderList);
}

/**
 * Loading a form to create a news entry.
 *
 * @return string
 */
function load_news_add(): string
{
    $placeholdeList = [
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_news_add');

    return strtr($template, $placeholdeList);
}

/**
 * Loading a form to delete a news message.
 *
 * @param int $id Id of a news
 * @return string
 */
function load_news_del(int $id): string
{
    $title = getTitleFromTableById('news', $id);
    
    $placeholderList = [
        '##placeholder-id##'    => $id,
        '##placeholder-title##' => $title
    ];
    
    $template = loadTemplate('adm_news_del');
    
    return strtr($template, $placeholderList);
}

/**
 * Load news settings form.
 * 
 * @return string
 */
function load_news_settings() : string
{
    $pdo = getPdoConnection();
    
    $sql = "SELECT `tagline`, `comment` FROM `news_settings` WHERE `id` = 1";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    $link = $stmt->fetch(PDO::FETCH_OBJ);
    
    $placeholderList = [
        '##placeholder-news-tagline##' => $link->tagline,
        '##placeholder-news-comment##' => $link->comment
    ];
    
    $template = loadTemplate('adm_news_settings');
    
    return strtr($template, $placeholderList);
}

/**
 * Load general overview of all download entries.
 *
 * @return string
 */
function load_downloads(): string
{
    $content = '';
    
    $stmt = loadDownloadsStatement();
    
    while ($downloads = $stmt->fetch(PDO::FETCH_OBJ)) {
        $content .= '<tr>';
        $content .= '<td>' . $downloads->id . '</td>';
        $content .= '<td>' . StrFTime('%d.%m.%Y %H:%M', $downloads->datetime) . '</td>';
        $content .= '<td>' . $downloads->title . '</td>';
        $content .= (($downloads->visibility > - 1) ? '<td> {yes}</td>' : '<td> {no}</td>');
        
        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" . $downloads->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" . $downloads->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsdel&id=" . $downloads->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
    }
    
    $template = loadTemplate('adm_downloads');
    $template = str_replace('##placeholder-downloads-content##', $content, $template);
    
    return $template;
}

/**
 * Loading a form to edit a downloads entry.
 *
 * @param int $id Id of a downloads entry.
 * @return string
 */
function load_downloads_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';
    
    $download = loadDownloadsEditStatement($id);
    
    if ($download->visibility > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'       => $download->id,
        '##placeholder-title##'    => $download->title,
        '##placeholder-path##'     => $download->path,
        '##placeholder-filename##' => $download->filename,
        '##placeholder-comment##'  => $download->comment,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $download->datetime),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = loadTemplate('adm_downloads_edit');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to create a downloads entry.
 *
 * @return string
 */
function load_downloads_add(): string
{
    $time = StrFTime('%d.%m.%Y %H:%M', time());
    
    $template = loadTemplate('adm_downloads_add');

    return str_replace('##placeholder-datetime##', $time, $template);
}

/**
 * Loading a form to delete a downloads entry
 *
 * @param int $id Id of a download
 * @return string
 */
function load_downloads_del(int $id): string
{
    $title = getTitleFromTableById('downloads', $id);
    
    $placeholderList = [
        '##placeholder-id##' => $id,
        '##placeholder-title##' => $title
    ];
    
    $template = loadTemplate('adm_downloads_del');
    
    return strtr($template, $placeholderList);
}

/**
 * Load downloads settings form.
 *
 * @return string
 */
function load_downloads_settings() : string
{
    $stmt = loadDownloadsSettingsStatement();
    
    $download = $stmt->fetch(PDO::FETCH_OBJ);
    
    $placeholderList = [
        '##placeholder-downloads-tagline##' => $download->tagline,
        '##placeholder-downloads-comment##' => $download->comment
    ];
    
    $template = loadTemplate('adm_downloads_settings');

    return strtr($template, $placeholderList);
}

/**
 * Load general overview of all links entries.
 *
 * @return string
 */
function load_links(): string
{
    $content = '';
    
    $stmt = loadLinksStatement();
    
    while ($link = $stmt->fetch(PDO::FETCH_OBJ)) {
        $content .= '<tr>';
        $content .= '<td>' . $link->id . '</td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $link->datetime) . '</td>';
        $content .= '<td>' . $link->title . '</td>';
        $content .= $link->visibility > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkdel&id=" . $link->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        $content .= '</tr>';
    }
    
    $template = loadTemplate('adm_links');
    
    return str_replace('##placeholder-links-content##', $content, $template);
}

/**
 * Loading a form to edit a link entry.
 *
 * @param int $id
 * @return string
 */
function load_link_edit(int $id): string
{
    $chkYes = '';
    $chkNo = '';

    $links = loadLinksEditStatement($id);

    if ($links->visibility > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-id##'      => $links->id,
        '##placeholder-title##'   => $links->title,
        '##placeholder-tagline##' => $links->tagline,
        '##placeholder-uri##'     => $links->uri,
        '##placeholder-comment##' => $links->comment,
        '##placeholder-chk_yes##' => $chkYes,
        '##placeholder-chk_no##'  => $chkNo
    ];

    $template = loadTemplate('adm_link_edit');
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * Loading a form to create a link entry.
 *
 * @return string
 */
function load_link_add(): string
{
    $placeholdeList = [
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_link_add');
    
    return strtr($template, $placeholdeList);
}

/**
 * Loading a form to delete a link entry.
 *
 * @param int $id - Id of a link entry.
 * @return string
 */
function load_link_del(int $id): string
{
    $title = getTitleFromTableById('links', $id);
    
    $placeholderList = [
        '##placeholder-id##'    => $id,
        '##placeholder-title##' => $title
    ];
    
    $template = loadTemplate('adm_link_del');
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Load links settings form.
 * 
 * @return string
 */
function load_link_settings() : string
{
    $placeholderList = [];
    
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `tagline`, `comment`' 
        . " FROM `links_settings` WHERE `id` = 1";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($link = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-link-tagline##' => $link->tagline,
            '##placeholder-link-comment##' => $link->comment
        ];
    }
    
    $template = loadTemplate('adm_links_settings');
    
    return strtr($template, $placeholderList);
}

/**
 * Load general overview of all articles.
 *
 * @return string
 */
function load_articles(): string
{
    $content = '';
    
    $stmt = loadArticlesStatement();
    
    while ($article = $stmt->fetch(PDO::FETCH_OBJ)) {
        $content .= '<tr>';
        $content .= '<td>' . $article->id . '</td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $article->datetime) . '</td>';
        $content .= '<td>' . $article->title . '</td>';
        $content .= $article->visibility > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articledel&id=" . $article->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $content .= '</tr>';
    }
    
    $template = loadTemplate('adm_articles');
    $template = str_replace('##placeholder-articles-content##', $content, $template);
    
    return $template;
}

/**
 * Loading a form to edit an article entry.
 *
 * @param int $id - Id of an article entry.
 * @return string
 */
function load_article_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';

    $article = loadArticlesEditStatement($id);

    if ($article->visibility > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-id##'       => $article->id,
        '##placeholder-title##'    => $article->title,
        '##placeholder-content##'  => $article->content,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M',$article->datetime),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = loadTemplate('adm_article_edit');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to create an article entry.
 *
 * @return string
 */
function load_article_add(): string
{
    $template = '';
    
    $template = loadTemplate('adm_article_add');
    
    $placeholderList = [
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Loading a form to delete an article entry.
 *
 * @param int $id
 * @return string
 */
function load_article_del(int $id): string
{
    $template = '';
    
    $title = getTitleFromTableById('articles', $id);
    
    $placeholderList = [
        '##placeholder-id##'    => $id,
        '##placeholder-title##' => $title
    ];
    
    $template = loadTemplate('adm_article_del');
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Load articles settings form.
 * 
 * @return string
 */
function load_articles_settings() : string
{
    $placeholderList = [];
    
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `tagline`, `comment`' 
        . " FROM `articles_settings` WHERE `id` = 1";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($article = $stmt->fetch(PDO::FETCH_OBJ)) {
        $placeholderList = [
            '##placeholder-article-tagline##' => $article->tagline,
            '##placeholder-article-comment##' => $article->comment
        ];
    }
    
    $template = loadTemplate('adm_articles_settings');
    
    return strtr($template, $placeholderList);
}

/**
 * Load dashboard form.
 * 
 * @return string
 */
function load_dashboard(): string
{
    return loadTemplate('adm_dashboard');
}

/**
 * Render a HTML-Table.
 * 
 * @deprecated
 * @param array $dataList
 * @return string
 */
function renderHtmlTable(array $dataList): string
{
    $html = '';
    
    foreach ($dataList as $data) {
        $html .= '<tr>';
        $html .= '<td>' . $data['id'] . '</td>';
        $html .= '<td>' . strftime('%d.%m.%Y', $data['datetime']) . '</td>';
        $html .= '<td>' . $data['title'] . '</td>';
        $html .= '<td>' . (($data['visibility'] > - 1) ? ' {yes}' : ' {no}') . '</td>';
        $html .= '</tr>';
    }
    
    return $html;
}

/**
 * Load entries that marked as 'trash'.
 * 
 * @deprecated
 * @return string
 */
function load_trash(): string
{
    $template = '';
    
    $news = loadTrashFromTable('news');
    $downloads = loadTrashFromTable('downloads');
    $links = loadTrashFromTable('links');
    $artikles = loadTrashFromTable('articles');
    
    $content = [
        $news,
        $downloads,
        $links,
        $artikles
    ];
    
    return loadTemplate('adm_trash');
}

/**
 * Load general overview of heinerCMS settings.
 * 
 * @return string
 */
function load_general_settings(): string
{
    $template = loadTemplate('adm_general_settings');
    
    $placeholderList = [
        '##placeholder-title##'         => $_SESSION['title'],
        '##placeholder-tagline##'       => $_SESSION['tagline'],
        '##placeholder-blog-url##'      => $_SESSION['blog-url'],
        '##placeholder-option-theme##'  => load_theme_options(),
        '##placeholder-option-locale##' => load_locale_options(),
        '##placeholder-footer##'        => $_SESSION['footer']
    ];
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Loading a string of theme options.
 * 
 * @return string
 */
function load_theme_options(): string
{
    $html = '';
    
    $template_dir = __DIR__ . '/../templates/';
    
    $files = scandir($template_dir);
    
    for ($i = 2; $i <= count($files) - 1; $i ++) {
        if ($files[$i] === $_SESSION['theme']) {
            $select = ' selected';
        } else {
            $select = '';
        }
        
        $html .= "<option $select>$files[$i]</option>";
    }
    
    return $html;
}

/**
 * Get a files list of all locales in data/locales directory
 *
 * @return string
 */
function load_locale_options() : string
{
    $html = '';
    
    $locale_dir = __DIR__ . '/../data/locales/';
    
    $files = scandir($locale_dir);

    for ($i = 2; $i <= count($files) -1; $i++) {
        $xmlFile = $locale_dir . $files[$i];

        $xmlString = file_get_contents($xmlFile);
        $xml = simplexml_load_string($xmlString);
        
        if ( $xml->attributes()->short == $_SESSION['language'] ) {
            $select = ' selected';
        } else {
            $select = '';
        }

        $html .= '<option value="' . $xml->attributes()->short .'"'.$select.'>' . $xml->attributes()->lang . '</option>';
    }

    return $html;
}

/**
 * Load general overview of all users.
 * 
 * @return string
 */
function load_user_list(): string
{
    $content = '';

    $stmt = loadUserStatement();
    
    while ($user = $stmt->fetch(PDO::FETCH_OBJ)) {

        $content .= '<tr>';
        $content .= '<td>' . $user->id . '</td>';
        $content .= '<td>' . $user->firstname . '</td>';
        $content .= '<td>' . $user->lastname . '</td>';
        $content .= '<td>' . $user->username . '</td>';
        $content .= '<td>' . $user->active . '</td>';

        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=useredit&id=" . $user->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';

        $content .= " <a href=" . $_SERVER['PHP_SELF'] . "?uri=userdel&id=" . $user->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';

        $content .= '</tr>';
    }

    $template = loadTemplate('adm_user_list');

    return str_replace('##placeholder-user-list-content##', $content, $template);
}

/**
 * Loading a form to edit an user entry.
 * 
 * @param int $id - Id of an user entry.
 * @return string
 */
function load_user_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';

    $user = loadUserEditStatement($id);

    if (strcmp($user->active, 'true') === 0) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-id##'        => $user->id,
        '##placeholder-datetime##'  => strftime('%d.%m.%Y %H:%M', $user->datetime),
        '##placeholder-firstname##' => $user->firstname,
        '##placeholder-lastname##'  => $user->lastname,
        '##placeholder-username##'  => $user->username,
        '##placeholder-email##'     => $user->email,
        '##placeholder-public-as##' => $user->username,
        '##placeholder-chk_yes##'   => $chkYes,
        '##placeholder-chk_no##'    => $chkNo
    ];

    $template = loadTemplate('adm_user_edit');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to create an user entry.
 * 
 * @return string
 */
function load_user_add(): string
{
    $placeholderList = [
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_user_insert');
    
    return strtr($template, $placeholderList);
}

/**
 * Loading a form to delete a user entry.
 * @param int $id
 * @return string
 */
function load_user_del( int $id) : string
{
    $placeholderList = [];
    
    $title = getUsernameById($id);
    
    $placeholderList = [
        '##placeholder-id##' => $id,
        '##placeholder-title##' => $title
    ];
    
    $template = loadTemplate('adm_user_del');
    
    return strtr($template, $placeholderList);
}

/**
 * Load general overview of all pages.
 * @return string
 */
function load_pages(): string
{
    $content = '';

    $stmt = loadPagesStatement();
    
    while ($page = $stmt->fetch(PDO::FETCH_OBJ)) {
        $content .= '<tr>';
        $content .= '<td>' . $page->id . '</td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $page->datetime) . '</td>';
        $content .= '<td>' . $page->title . '</td>';
        $content .= $page->visibility > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=pageedit&id=" . $page->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=pageedit&id=" . $page->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=pagedel&id=" . $page->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $content .= '</tr>';
    }
    
    $template = loadTemplate('adm_pages');
    
    return str_replace('##placeholder-pages-content##', $content, $template);
}

/**
 * Loading a form to create a page entry.
 * 
 * @return string
 */
function load_page_add(): string
{   
    $placeholdeList = [
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_page_add');
    
    return strtr($template, $placeholdeList);
}

/**
 * Loading a form to edit a page entry.
 * 
 * @param int $id - Id of a page entry.
 * @return string
 */
function load_page_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';

    $page = loadPageEditStatement($id);

    if ($page->visibility > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-id##'       => $page->id,
        '##placeholder-title##'    => $page->title,
        '##placeholder-tagline##'  => $page->tagline,
        '##placeholder-content##'  => $page->content,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $page->datetime),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = loadTemplate('adm_page_edit');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to delete a page entry.
 * 
 * @return string
 */
function load_page_del(): string
{
    return loadTemplate('adm_page_del');
}

/**
 * Load general overview of mainpage.
 * 
 * @return string
 */
function load_mainpage() : string
{
    return loadTemplate('adm_mainpage');
}
