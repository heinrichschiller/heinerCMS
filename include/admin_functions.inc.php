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
        '##placeholder-downloads##' => $entries[0],
        '##placeholder-links##'     => $entries[1],
        '##placeholder-articles##'  => $entries[2],
        '##placeholder-pages##'     => $entries[3],
        '##placeholder-trash##'     => $entries[4]
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
 * Load general overview of all download entries.
 *
 * @return string
 */
function load_downloads(): string
{
    $content = '';
    
    $hasEntry = false;
    
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
        
        $hasEntry = true;
    }
    
    if($hasEntry) {
        $placeholderList = [
            '##placeholder-icon##'   => '../templates/default/admin/img/svg/si-glyph-file-download.svg',
            '##placeholder-header##' => ' {downloads}',
            '##placeholder-uri##'    => 'index.php?uri=downloadsadd',
            '##placeholder-button##' => '{create_download}'
        ];
        
        $template = loadTemplate('adm_table');
        $template = strtr($template, $placeholderList);

        $tplDownloadsEntries = loadTemplate('adm_downloads_entries');
        $tplDownloadsEntries = str_replace('##placeholder-table-content##', $content, $tplDownloadsEntries);
        $template = str_replace('##placeholder-content##', $tplDownloadsEntries, $template);
    } else {
        $template = loadTemplate('adm_no_downloads');
    }

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
    
    list($id, $title, $comment, $path, $filename, $created_at, $visibility) = getDownloads($id);
    
    if ($visibility > - 1) {
        $chkYes .= ' checked';
    } else {
        $chkNo .= ' checked';
    }
    
    $placeholderList = [
        '##placeholder-header##'   => '{edit_download}',
        '##placeholder-action##'   => 'downloadsupdate.php',
        '##placeholder-id##'       => $id,
        '##placeholder-title##'    => $title,
        '##placeholder-path##'     => $path,
        '##placeholder-filename##' => $filename,
        '##placeholder-comment##'  => $comment,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $created_at),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = loadTemplate('adm_downloads_form');

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
    
    $placeholderList = [
        '##placeholder-header##'   => '{create_download}',
        '##placeholder-action##'   => 'downloadsinsert.php',
        '##placeholder-id##'       => '{new}',
        '##placeholder-title##'    => '',
        '##placeholder-path##'     => '',
        '##placeholder-filename##' => '',
        '##placeholder-comment##'  => '',
        '##placeholder-datetime##' => $time,
        '##placeholder-chk_yes##'  => ' checked',
        '##placeholder-chk_no##'   => ''
    ];
    
    $template = loadTemplate('adm_downloads_form');

    return strtr($template, $placeholderList);
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
        '##placeholder-action##' => 'downloadsdel.php',
        '##placeholder-uri##'    => 'downloads',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];
    
    $template = loadTemplate('adm_form_del');
    
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
    
    $hasEntry = false;
    
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
        
        $hasEntry = true;
    }
    
    if($hasEntry) {
        $placeholderList = [
            '##placeholder-icon##'   => '../templates/default/admin/img/svg/si-glyph-global.svg',
            '##placeholder-header##' => ' {links}',
            '##placeholder-uri##'    => 'index.php?uri=linksadd',
            '##placeholder-button##' => '{create_link}'
        ];
        
        $template = loadTemplate('adm_table');
        $template = strtr($template, $placeholderList);
        
        $tplLinksEntries = loadTemplate('adm_links_entries');
        $tplLinksEntries = str_replace('##placeholder-table-content##', $content, $tplLinksEntries);
        
        $template =str_replace('##placeholder-content##', $tplLinksEntries, $template);
    } else {
        $template = loadTemplate('adm_no_links');
    }
    
    return $template;
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

    list($id, $title, $tagline, $uri, $comment, $created_at, $visibility) = getLinks($id);

    if ($visibility > - 1) {
        $chkYes .= ' checked';
    } else {
        $chkNo .= ' checked';
    }

    $placeholderList = [
        '##placeholder-header##'   => '{create_link}',
        '##placeholder-action##'   => 'linkinsert.php',
        '##placeholder-id##'       => '{new}',
        '##placeholder-id##'       => $id,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $created_at),
        '##placeholder-title##'    => $title,
        '##placeholder-tagline##'  => $tagline,
        '##placeholder-uri##'      => $uri,
        '##placeholder-comment##'  => $comment,
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = loadTemplate('adm_link_form');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to create a link entry.
 *
 * @return string
 */
function load_link_add(): string
{
    $placeholdeList = [
        '##placeholder-header##'   => '{create_link}',
        '##placeholder-action##'   => 'linkinsert.php',
        '##placeholder-id##'       => '{new}',
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', time()),
        '##placeholder-title##'    => '',
        '##placeholder-tagline##'  => '',
        '##placeholder-uri##'      => '',
        '##placeholder-comment##'  => '',
        '##placeholder-chk_yes##'  => ' checked',
        '##placeholder-chk_no##'   => ''
    ];
    
    $template = loadTemplate('adm_link_form');
    
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
        '##placeholder-action##' => 'linkdel.php',
        '##placeholder-uri##'    => 'links',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];
    
    $template = loadTemplate('adm_form_del');
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
    $hasEntry = false;
    
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
        
        $hasEntry = true;
    }
    
    if($hasEntry) {
        $placeholderList = [
            '##placeholder-icon##'   => '../templates/default/admin/img/svg/si-glyph-pen.svg',
            '##placeholder-header##' => ' {articles}',
            '##placeholder-uri##'    => 'index.php?uri=articleadd',
            '##placeholder-button##' => '{create_article}'
        ];
        
        $template = loadTemplate('adm_table');
        $template = strtr($template, $placeholderList);
        
        $tplArticlesEntries = loadTemplate('adm_articles_entries');
        $tplArticlesEntries = str_replace('##placeholder-table-content##', $content, $tplArticlesEntries);
        
        $template = str_replace('##placeholder-content##', $tplArticlesEntries, $template);
    } else {
        $template = loadTemplate('adm_no_articles');
    }

    return $template;
}

/**
 * Loading a form to edit an article entry.
 *
 * @param int $id - Id of an article entry.
 * @return string
 * 
 * @since 0.4.0
 */
function load_article_edit(int $id): string
{
    $chkNo = '';
    $chkYes = '';
    
    list($id, $title, $content, $created_at, $visibility) = getArticle($id);
    
    if ($visibility > - 1) {
        $chkYes .= ' checked';
    } else {
        $chkNo .= ' checked';
    }
    
    $placeholderList = [
        '##placeholder-header##'   => '{edit_article}',
        '##placeholder-action##'   => 'articleupdate.php',
        '##placeholder-id##'       => $id,
        '##placeholder-title##'    => $title,
        '##placeholder-content##'  => $content,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $created_at),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];
    
    $template = loadTemplate('adm_article_form');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to create an article entry.
 *
 * @return string
 * 
 * @since 0.4.0
 */
function load_article_add(): string
{
    $placeholderList = [
        '##placeholder-header##'   => '{create_article}',
        '##placeholder-action##'   => 'articleinsert.php',
        '##placeholder-id##'       => '{new}',
        '##placeholder-title##'    => '',
        '##placeholder-content##'  => '',
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', time()),
        '##placeholder-chk_yes##'  => ' checked',
        '##placeholder-chk_no##'   => ''
    ];
    
    $template = loadTemplate('adm_article_form');
    
    return strtr($template, $placeholderList);
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
        '##placeholder-action##' => 'articlesdel.php',
        '##placeholder-uri##'    => 'articles',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];
    
    $template = loadTemplate('adm_form_del');
    
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

function load_communication(): string
{
    return loadTemplate('adm_communication');
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

    $downloads = loadTrashFromTable('downloads');
    $links = loadTrashFromTable('links');
    $artikles = loadTrashFromTable('articles');
    
    $content = [
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
    
    $files = scandir(LOCALES_PATH);

    for ($i = 2; $i <= count($files) -1; $i++) {
        $xmlFile = LOCALES_PATH . $files[$i];

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
    
    $hasEntry = false;

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
        
        $hasEntry = true;
    }

    if($hasEntry) {
        $placeholderList = [
            '##placeholder-icon##'   => '../templates/default/admin/img/svg/si-glyph-document.svg',
            '##placeholder-header##' => ' {pages}',
            '##placeholder-uri##'    => 'index.php?uri=pageadd',
            '##placeholder-button##' => '{create_page}'
        ];
        
        $template = loadTemplate('adm_pages');
        $template = strtr($template, $placeholderList);
        
        $tplPages = loadTemplate('adm_pages_entries');
        $tplPages = str_replace('##placeholder-table-content##', $content, $tplPages);
        
        $template = str_replace('##placeholder-content##', $tplPages, $template);
    } else {
        $template = loadTemplate('adm_no_pages');
    }
    
    $tplPages = loadTemplate('adm_pages_entries');
    $tplPages = str_replace('##placeholder-table-content##', $content, $tplPages);
    
    return $template;
}

/**
 * Loading a form to create a page entry.
 * 
 * @return string
 */
function load_page_add(): string
{   
    $placeholdeList = [
        '##placeholder-header##'   => '{create_page}',
        '##placeholder-action##'   => 'pageinsert.php',
        '##placeholder-id##'       => '{new}',
        '##placeholder-datetime##' => StrFTime('%d.%m.%Y %H:%M', time()),
        '##placeholder-title##'    => '',
        '##placeholder-tagline##'  => '',
        '##placeholder-content##'  => '',
        '##placeholder-chk_yes##'  => ' checked',
        '##placeholder-chk_no##'   => ''
    ];
    
    $template = loadTemplate('adm_page_form');
    
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

    list($id, $title, $tagline, $content, $created_at, $visibility) = getPage($id);

    if ($visibility > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-header##'   => '{edit_page}',
        '##placeholder-action##'   => 'pageupdate.php',
        '##placeholder-id##'       => $id,
        '##placeholder-title##'    => $title,
        '##placeholder-tagline##'  => $tagline,
        '##placeholder-content##'  => $content,
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $created_at),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = loadTemplate('adm_page_form');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to delete a page entry.
 * 
 * @param int $id
 * 
 * @return string
 * 
 * @since 0.4.0
 */
function load_page_del($id): string
{
    $title = getTitleFromTableById('sites', $id);
        
    $placeholderList = [
        '##placeholder-action##' => 'pagedel.php',
        '##placeholder-uri##'    => 'pages',
        '##placeholder-id##'    => $id,
        '##placeholder-title##' => $title
    ];

    $template = loadTemplate('adm_form_del');

    return strtr($template, $placeholderList);
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
