<?php

/**
 *  Überprüft, ob ein Login erfolgt ist 
 */
function is_logged_in() {
    
    $authenticated = isset($_SESSION['authenticated']) ? true : false;
    
    load_session();
    
    /* User angemeldet? */
    if ($authenticated) {
        return true;
    } else {
        
        $login = loadTemplate('adm_login');
        $template = loadTemplate('adm_login_template');
        
        $template = str_replace ( '##placeholder-title##', $_SESSION['title'], $template );
        $template = str_replace ( '##placeholder-form-signin##', $login, $template );
        
        echo stripslashes ( $template );
        
        return false;
    }
}

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
 * General overview of all news
 *
 * @return string
 */
function load_news(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoConnection();
    
    $template = loadTemplate('adm_news');
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`' 
        . " FROM `news` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $news->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y', $news->datetime) . '</td>';
        $table_content .= '<td>' . $news->title . '</td>';
        $table_content .= $news->visible > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $table_content .= '<td>';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" . $news->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" . $news->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsdel&id=" . $news->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a>';
        
        $table_content .= '</td>';
        $table_content .= '</tr>';
    }
    
    return str_replace('##placeholder-table-content##', $table_content, $template);
}

/**
 * Formular zum Bearbeiten einer Nachricht laden
 *
 * @param int $id Id of a news
 * @return string
 */
function load_news_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';
    
    $params = [
        $id
    ];
    
    $sql = 'SELECT `id`, `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`' 
        . " FROM `news` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'       => $result['id'],
        '##placeholder-title##'    => $result['title'],
        '##placeholder-message##'  => $result['message'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = loadTemplate('adm_news_edit');
    
    return strtr($template, $placeholderList);
}

/**
 * Formular zum Erstellen einer Nachricht laden
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
 * Delete a news
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
 * Load news settings.
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
 * Gesamtübersicht der Downloads laden
 *
 * @return string
 */
function load_downloads(): string
{
    $table_content = '';
    
    $pdo = getPdoConnection();
    
    $template = loadTemplate('adm_downloads');
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible`' 
        . " FROM `downloads` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($downloads = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $downloads->id . '</td>';
        $table_content .= '<td>' . StrFTime('%d.%m.%Y %H:%M', $downloads->datetime) . '</td>';
        $table_content .= '<td>' . $downloads->title . '</td>';
        $table_content .= (($downloads->visible > - 1) ? '<td> {yes}</td>' : '<td> {no}</td>');
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" . $downloads->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" . $downloads->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsdel&id=" . $downloads->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
    }
    
    $template = str_replace('##placeholder-downloads-content##', $table_content, $template);
    
    return $template;
}

/**
 * Formular zum Bearbeiten eines Downloads laden
 *
 * @param int $id Id of a download.
 * @return string
 */
function load_downloads_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';
    
    $params = [
        $id
    ];
    
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `id`, `title`, `comment`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible`' 
        . " FROM `downloads` WHERE `id`=$id";
    
    $result = pdo_select($sql, $params);
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'       => $result['id'],
        '##placeholder-title##'    => $result['title'],
        '##placeholder-path##'     => $result['path'],
        '##placeholder-filename##' => $result['filename'],
        '##placeholder-comment##'  => $result['comment'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = loadTemplate('adm_downloads_edit');

    return strtr($template, $placeholderList);
}

/**
 * Load a formular to create a download
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
 * Delete download
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
 * Load news settings.
 *
 * @return string
 */
function load_downloads_settings() : string
{
    $pdo = getPdoConnection();
    
    $sql = "SELECT `tagline`, `comment` FROM `downloads_settings` WHERE `id` = 1";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    $download = $stmt->fetch(PDO::FETCH_OBJ);
    
    $placeholderList = [
        '##placeholder-downloads-tagline##' => $download->tagline,
        '##placeholder-downloads-comment##' => $download->comment
    ];
    
    $template = loadTemplate('adm_downloads_settings');

    return strtr($template, $placeholderList);
}

/**
 * Gesamtübersicht der Links laden
 *
 * @return string
 */
function load_links(): string
{
    $table_content = '';
    
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `id`, `title`, `uri`, UNIX_TIMESTAMP(`created_at`) as datetime, `visible`' 
        . " FROM `links` WHERE `trash` = 'false' ORDER BY `title` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($link = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $link->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y', $link->datetime) . '</td>';
        $table_content .= '<td>' . $link->title . '</td>';
        $table_content .= $link->visible > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkdel&id=" . $link->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        $table_content .= '</tr>';
    }
    
    $template = loadTemplate('adm_links');
    
    return str_replace('##placeholder-links-content##', $table_content, $template);
}

/**
 * Formular zum Bearbeiten eines Links laden
 *
 * @param int $id
 * @return string
 */
function load_link_edit(int $id): string
{
    $chkYes = '';
    $chkNo = '';
    
    $params = [
        $id
    ];
    
    $sql = "SELECT `id`, `title`, `tagline`, `uri`, `comment`, `visible` FROM `links` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'      => $result['id'],
        '##placeholder-title##'   => $result['title'],
        '##placeholder-tagline##' => $result['tagline'],
        '##placeholder-uri##'     => $result['uri'],
        '##placeholder-comment##' => $result['comment'],
        '##placeholder-chk_yes##' => $chkYes,
        '##placeholder-chk_no##'  => $chkNo
    ];
    
    $template = loadTemplate('adm_link_edit');
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Formular zum Erstellen einer Nachricht laden
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
 * Link löschen
 *
 * @param int $id
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
 * Load general overview of all articles
 *
 * @return string
 */
function load_articles(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoConnection();
    
    $template = loadTemplate('adm_articles');
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`' 
        . " FROM `articles` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($article = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $article->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y', $article->datetime) . '</td>';
        $table_content .= '<td>' . $article->title . '</td>';
        $table_content .= $article->visible > - 1 ? '<td> {yes}</td>' : '<td> {no}</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articledel&id=" . $article->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $table_content .= '</tr>';
    }
    
    $template = str_replace('##placeholder-articles-content##', $table_content, $template);
    
    return $template;
}

/**
 * Formular zum Bearbeiten eines Artikels laden
 *
 * @param int $id
 * @return string
 */
function load_article_edit(int $id): string
{
    $template = '';
    $params = [
        $id
    ];
    $chkNo = '';
    $chkYes = '';
    
    $sql = "SELECT `id`, `title`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `articles` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    $template = loadTemplate('adm_article_edit');
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'       => $result['id'],
        '##placeholder-title##'    => $result['title'],
        '##placeholder-content##'  => $result['content'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Formular zum Erstellen eines Artikels laden
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
 * Artikel löschen
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
 *
 * @return string
 */
function load_dashboard(): string
{
    return loadTemplate('adm_dashboard');
}

/**
 *
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
        $html .= '<td>' . (($data['visible'] > - 1) ? ' {yes}' : ' {no}') . '</td>';
        $html .= '</tr>';
    }
    
    return $html;
}

/**
 *
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
 *
 * @return string
 */
function load_user_list(): string
{
    $table_content = '';
    
    $pdo = getPdoConnection();
    
    $template = loadTemplate('adm_user_list');
    $sql = 'SELECT `id`,`firstname`,`lastname`,`username`,`active`' 
        . ' FROM `users` ORDER BY `firstname` DESC';
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($user = $stmt->fetch(PDO::FETCH_OBJ)) {
        
        $table_content .= '<tr>';
        $table_content .= '<td>' . $user->id . '</td>';
        $table_content .= '<td>' . $user->firstname . '</td>';
        $table_content .= '<td>' . $user->lastname . '</td>';
        $table_content .= '<td>' . $user->username . '</td>';
        $table_content .= '<td>' . $user->active . '</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=useredit&id=" . $user->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= " <a href=" . $_SERVER['PHP_SELF'] . "?uri=userdel&id=" . $user->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $table_content .= '</tr>';
    }
    
    return str_replace('##placeholder-user-list-content##', $table_content, $template);
}

/**
 *
 * @param int $id
 * @return string
 */
function load_user_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';
    
    $params = [
        $id
    ];
    
    $template = loadTemplate('adm_user_edit');
    
    $sql = 'SELECT `id`, `firstname`, `lastname` ,`email`, `password`, UNIX_TIMESTAMP(`created_at`) AS datetime, `updated_at`, `username`, `active`' 
        . ' FROM `users`' . ' WHERE `id` = ?';
    
    $user = pdo_select($sql, $params);
    
    if (strcmp($user['active'], 'true') === 0) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##' => $user['id'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $user['datetime']),
        '##placeholder-firstname##' => $user['firstname'],
        '##placeholder-lastname##' => $user['lastname'],
        '##placeholder-username##' => $user['username'],
        '##placeholder-email##' => $user['email'],
        '##placeholder-public-as##' => $user['username'],
        '##placeholder-chk_yes##' => $chkYes,
        '##placeholder-chk_no##' => $chkNo
    ];
    
    return strtr($template, $placeholderList);
}

/**
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
 *
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
 *
 * @return string
 */
function load_pages(): string
{
    $table_content = '';
    $php_self = 
    
    $pdo = getPdoConnection();
    
    $template = loadTemplate('adm_pages');
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`' 
        . " FROM `sites` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($page = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $page->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y', $page->datetime) . '</td>';
        $table_content .= '<td>' . $page->title . '</td>';
        $table_content .= '<td>' . $page->visible > - 1 ? '<td> ja</td>' : '<td> nein</td>' . '</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=pageedit&id=" . $page->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=pageedit&id=" . $page->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=pagedel&id=" . $page->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $table_content .= '</tr>';
    }
    
    return str_replace('##placeholder-pages-content##', $table_content, $template);
}

/**
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
 *
 * @param int $id
 * @return string
 */
function load_page_edit(int $id): string
{
    $params = [
        $id
    ];
    $chkNo = '';
    $chkYes = '';
    
    $sql = "SELECT `id`, `title`, `tagline`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `sites` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    $template = loadTemplate('adm_page_edit');
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '##placeholder-id##'       => $result['id'],
        '##placeholder-title##'    => $result['title'],
        '##placeholder-tagline##'  => $result['tagline'],
        '##placeholder-content##'  => $result['content'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    return strtr($template, $placeholderList);
}

/**
 *
 * @return string
 */
function load_page_del(): string
{
    return loadTemplate('adm_page_del');
}

/**
 *
 * @return string
 */
function load_mainpage() : string
{
    return loadTemplate('adm_mainpage');
}

/*
 * *******************************************************************************
 * SQL - section
 * *******************************************************************************
 */

/**
 * Count all Entries for navigation information
 *
 * @return array
 */
function countEntries()
{
    $pdo = getPdoConnection();
    
    $sql = "SELECT COUNT(`id`) as result FROM `news` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `downloads` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `links` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `articles` WHERE `trash` = 'false'
        UNION ALL
        SELECT COUNT(`id`) FROM `sites` WHERE `trash` = 'false'
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
                UNION ALL
                SELECT `trash` FROM `sites`
                ) as subquery
                WHERE `trash` = 'true';";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
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
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`' 
        . " FROM `$table` WHERE `trash` = 'false' ORDER BY `created_at` DESC LIMIT $count";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    return $stmt->fetchAll();
}

/**
 * Get id, title and datetime from a table where trash-flag is true.
 *
 * @param string $table Name of a table.
 * @return array
 */
function loadTrashFromTable(string $table)
{
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime' 
        . " FROM `$table` WHERE `trash` = 'true' ORDER BY `created_at` DESC";
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
    }
    
    return $stmt->fetchAll();
}

/**
 * Get title from a table by id
 *
 * @param string $table
 *            - Name of a table
 * @param int $id
 *            - Id
 *            
 * @return string
 */
function getTitleFromTableById(string $table, int $id)
{
    $pdo = getPdoConnection();
    
    $sql = "SELECT `title` FROM `$table` WHERE `id` = :id";
    
    $input_parameters = [
        ':id' => $id
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
    }
    
    return $stmt->fetchColumn();
}

/**
 * Get username by id
 *
 * @param int $id Id of an user       
 *      
 * @return string
 */
function getUsernameById(int $id)
{
    $pdo = getPdoConnection();
    
    $sql = "SELECT `username` FROM `users` WHERE `id` = :id";
    
    $input_parameters = [
        ':id' => $id
    ];
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
    
    return $stmt->fetchColumn();
}

/**
 *
 * @param string $table
 */
function deleteAllTrashItems(string $table)
{
    $pdo = getPdoConnection();
    
    $sql = "DELETE FROM `:table` WHERE `trash` = 'true'";
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
    }
}

/**
 *
 * @param array $items
 * @param string $table
 */
function deleteItemsById(array $items, string $table)
{
    $pdo = getPdoConnection();
    
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
        exit();
    }
}

/**
 *
 * @param int $id
 * @param string $table
 */
function setFlagTrashById(int $id, string $table)
{
    $pdo = getPdoConnection();
    
    $sql = "UPDATE `$table` SET `trash`='true' WHERE `id`= :id";
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':id' => $id
        ));
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
    }
}
