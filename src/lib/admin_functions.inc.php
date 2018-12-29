<?php

/**
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * MIT License
 *
 * Copyright (c) 2017 - 2019 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 *
 * @deprecated: This is a deprecated file and will be removed in the future.
 *
 */
/**
 * Load the admin navigation with badges
 *
 * @return string
 */
function load_navigation(): string
{
    $entries = countEntries();

    $placeholderList = [
        '##placeholder-articles##'  => $entries[0],
        '##placeholder-downloads##' => $entries[1],
        '##placeholder-links##'     => $entries[2],
        '##placeholder-pages##'     => $entries[3],
        '##placeholder-trash##'     => $entries[4]
    ];

    $template = getTemplate('adm_navigation');

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

    $template = getTemplate('adm_sidebar');

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

    while ($downloads = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';
        $content .= '<td></td>';
        $content .= '<td>' . StrFTime('%d.%m.%Y', $downloads['datetime']) . '</td>';
        $content .= '<td>' . $downloads['title'] . '</td>';
        $content .= (($downloads['visibility'] == 'true') ? '<td> {yes}</td>' : '<td> {no}</td>');

        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" . $downloads['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" . $downloads['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsdel&id=" . $downloads['id'] . ">"
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

        $template = getTemplate('adm_table');
        $template = strtr($template, $placeholderList);

        $tplDownloadsEntries = getTemplate('adm_downloads_entries');
        $tplDownloadsEntries = str_replace('##placeholder-table-content##', $content, $tplDownloadsEntries);
        $template = str_replace('##placeholder-content##', $tplDownloadsEntries, $template);
    } else {
        $template = getTemplate('adm_no_downloads');
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

    $downloadItems = getDownloads($id);

    if ($downloadItems['visibility'] == 'true') {
        $chkYes .= ' checked';
    } else {
        $chkNo .= ' checked';
    }

    $placeholderList = [
        '##placeholder-header##'   => '{edit_download}',
        '##placeholder-action##'   => 'downloadsupdate.php',
        '##placeholder-id##'       => $downloadItems['id'],
        '##placeholder-title##'    => $downloadItems['title'],
        '##placeholder-path##'     => $downloadItems['path'],
        '##placeholder-filename##' => $downloadItems['filename'],
        '##placeholder-comment##'  => $downloadItems['text'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $downloadItems['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = getTemplate('adm_downloads_form');

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

    $template = getTemplate('adm_downloads_form');

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
    $title = getContentsTitleById($id);

    $placeholderList = [
        '##placeholder-action##' => 'downloadsdel.php',
        '##placeholder-uri##'    => 'downloads',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];

    $template = getTemplate('adm_form_del');

    return strtr($template, $placeholderList);
}

/**
 * Load downloads settings form.
 *
 * @return string
 */
function load_downloads_settings() : string
{
    $download = getDownloadSettings();

    $placeholderList = [
        '##placeholder-downloads-tagline##' => $download['tagline'],
        '##placeholder-downloads-text##' => $download['text']
    ];

    $template = getTemplate('adm_downloads_settings');

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

    while ($link = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';
        $content .= '<td></td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $link['datetime']) . '</td>';
        $content .= '<td>' . $link['title'] . '</td>';
        $content .= $link['visibility'] == 'true' ? '<td> {yes}</td>' : '<td> {no}</td>';

        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkdel&id=" . $link['id']. ">"
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

        $template = getTemplate('adm_table');
        $template = strtr($template, $placeholderList);

        $tplLinksEntries = getTemplate('adm_links_entries');
        $tplLinksEntries = str_replace('##placeholder-table-content##', $content, $tplLinksEntries);

        $template =str_replace('##placeholder-content##', $tplLinksEntries, $template);
    } else {
        $template = getTemplate('adm_no_links');
    }

    return $template;
}

/**
 * Loading a form to edit a link entry.
 *
 * @param int $id
 * @return string
 *
 * @since 0.8.0
 */
function load_link_edit(int $id): string
{
    $chkYes = '';
    $chkNo = '';

    $linkItems = getLinks($id);

    if ($linkItems['visibility'] == 'true') {
        $chkYes .= ' checked';
    } else {
        $chkNo .= ' checked';
    }

    $placeholderList = [
        '##placeholder-header##'   => '{create_link}',
        '##placeholder-action##'   => 'linkupdate.php',
        '##placeholder-id##'       => '{new}',
        '##placeholder-id##'       => $linkItems['id'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $linkItems['datetime']),
        '##placeholder-title##'    => $linkItems['title'],
        '##placeholder-tagline##'  => $linkItems['tagline'],
        '##placeholder-uri##'      => $linkItems['uri'],
        '##placeholder-comment##'  => $linkItems['text'],
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = getTemplate('adm_link_form');

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

    $template = getTemplate('adm_link_form');

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
    $title = getContentsTitleById($id);

    $placeholderList = [
        '##placeholder-action##' => 'linkdel.php',
        '##placeholder-uri##'    => 'links',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];

    $template = getTemplate('adm_form_del');
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
    $link = getLinksSettings();

    $placeholderList = [
        '##placeholder-link-tagline##' => $link['tagline'],
        '##placeholder-link-comment##' => $link['text']
    ];

    $template = getTemplate('adm_links_settings');

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

    while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';
        $content .= '<td></td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $article['datetime']) . '</td>';
        $content .= '<td>' . $article['title'] . '</td>';
        $content .= $article['visibility'] == 'true' ? '<td> {yes}</td>' : '<td> {no}</td>';

        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articledel&id=" . $article['id'] . ">"
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

        $template = getTemplate('adm_table');
        $template = strtr($template, $placeholderList);

        $tplArticlesEntries = getTemplate('adm_articles_entries');
        $tplArticlesEntries = str_replace('##placeholder-table-content##', $content, $tplArticlesEntries);

        $template = str_replace('##placeholder-content##', $tplArticlesEntries, $template);
    } else {
        $template = getTemplate('adm_no_articles');
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

    $articleItems = getArticle($id);

    if ($articleItems['visibility'] == 'true') {
        $chkYes .= ' checked';
    } else {
        $chkNo .= ' checked';
    }

    $placeholderList = [
        '##placeholder-header##'   => '{edit_article}',
        '##placeholder-action##'   => 'articleupdate.php',
        '##placeholder-id##'       => $articleItems['id'],
        '##placeholder-title##'    => $articleItems['title'],
        '##placeholder-content##'  => $articleItems['text'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $articleItems['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = getTemplate('adm_article_form');

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

    $template = getTemplate('adm_article_form');

    return strtr($template, $placeholderList);
}

/**
 * Loading a form to delete an article entry.
 *
 * @param int $id - Id of an article entry.
 * @return string
 */
function load_article_del(int $id): string
{
    $title = getContentsTitleById($id);

    $placeholderList = [
        '##placeholder-action##' => 'articledel.php',
        '##placeholder-uri##'    => 'articles',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];

    $template = getTemplate('adm_form_del');
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
    $article = getArticleSettings();

    $placeholderList = [
        '##placeholder-article-tagline##' => $article['tagline'],
        '##placeholder-article-comment##' => $article['text']
    ];

    $template = getTemplate('adm_articles_settings');

    return strtr($template, $placeholderList);
}

/**
 * Load dashboard form.
 *
 * @return string
 */
function load_dashboard(): string
{
    return getTemplate('adm_dashboard');
}

function load_communication(): string
{
    return getTemplate('adm_communication');
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
 * Load entries from contents-table that marked as 'trash'.
 *
 * @return string
 *
 * @since 0.8.0
 */
function load_trash(): string
{
    $content = '';
    $hasEntry = false;

    $stmt = getTrashEntries();

    while ($contentList = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';
        $content .= '<td><!-- <input type="checkbox" name="chkList[]"> --></td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $contentList['datetime']) . '</td>';
        $content .= '<td>' . $contentList['title'] . '</td>';
        $content .= '<td>{' . $contentList['content_type'] . '}</td>';

        $content .= "<td><a href=/admin/delete.php?id=" . $contentList['id'] . " class='dialog-confirm'>"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';

        $content .= '</tr>';

        $hasEntry = true;
    }

    if($hasEntry) {
        $placeholderList = [
            '##placeholder-icon##'   => '../templates/default/admin/img/svg/si-glyph-trash.svg',
            '##placeholder-header##' => ' {trash}',
            '##placeholder-uri##'    => 'index.php?uri=delete',
            '##placeholder-button##' => '{delete}'
        ];

        $template = getTemplate('adm_trash_table');
        $template = strtr($template, $placeholderList);

        $tplArticlesEntries = getTemplate('adm_trash');
        $tplArticlesEntries = str_replace('##placeholder-table-content##', $content, $tplArticlesEntries);

        $template = str_replace('##placeholder-content##', $tplArticlesEntries, $template);
    } else {
        $template = getTemplate('adm_no_trash');
    }

    return $template;
}

/**
 * Load general overview of heinerCMS settings.
 *
 * @return string
 */
function load_general_settings(): string
{
    $template = getTemplate('adm_general_settings');

    $placeholderList = [
        '##placeholder-title##'         => $_SESSION['title'],
        '##placeholder-tagline##'       => $_SESSION['tagline'],
        '##placeholder-blog-url##'      => $_SESSION['blog-url'],
        '##placeholder-option-theme##'  => load_theme_options(),
        '##placeholder-checked##'       => $_SESSION['darkmode'],
        '##placeholder-option-locale##' => load_locale_options(),
        '##placeholder-footer##'        => $_SESSION['footer']
    ];

    $template = strtr($template, $placeholderList);

    return $template;
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

    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $content .= '<tr>';
        $content .= '<td>' . $user['id'] . '</td>';
        $content .= '<td>' . $user['firstname'] . '</td>';
        $content .= '<td>' . $user['lastname'] . '</td>';
        $content .= '<td>' . $user['username'] . '</td>';
        $content .= '<td>' . $user['active'] . '</td>';

        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=useredit&id=" . $user['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';

        $content .= " <a href=" . $_SERVER['PHP_SELF'] . "?uri=userdel&id=" . $user['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';

        $content .= '</tr>';
    }

    $template = getTemplate('adm_user_list');

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

    $user = getUser($id);

    if (strcmp($user['active'], 'true') === 0) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-id##'        => $user['id'],
        '##placeholder-datetime##'  => strftime('%d.%m.%Y %H:%M', $user['datetime']),
        '##placeholder-firstname##' => $user['firstname'],
        '##placeholder-lastname##'  => $user['lastname'],
        '##placeholder-username##'  => $user['username'],
        '##placeholder-email##'     => $user['email'],
        '##placeholder-public-as##' => $user['username'],
        '##placeholder-chk_yes##'   => $chkYes,
        '##placeholder-chk_no##'    => $chkNo
    ];

    $template = getTemplate('adm_user_edit');

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

    $template = getTemplate('adm_user_insert');

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

    $template = getTemplate('adm_user_del');

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

    while ($page = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $content .= '<tr>';
        $content .= '<td></td>';
        $content .= '<td>' . strftime('%d.%m.%Y', $page['datetime']) . '</td>';
        $content .= '<td>' . $page['title'] . '</td>';
        $content .= $page['visibility'] == 'true' ? '<td> {yes}</td>' : '<td> {no}</td>';

        $content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=pageedit&id=" . $page['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=pageedit&id=" . $page['id'] . ">"
            . '<img class="glyph-icon-16" src="../templates/default/admin/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';

        $content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=pagedel&id=" . $page['id'] . ">"
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

        $template = getTemplate('adm_table');
        $template = strtr($template, $placeholderList);

        $tplPages = getTemplate('adm_pages_entries');
        $tplPages = str_replace('##placeholder-table-content##', $content, $tplPages);

        $template = str_replace('##placeholder-content##', $tplPages, $template);
    } else {
        $template = getTemplate('adm_no_pages');
    }

    $tplPages = getTemplate('adm_pages_entries');
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

    $template = getTemplate('adm_page_form');

    return strtr($template, $placeholdeList);
}

/**
 * Loading a form to delete an article entry.
 *
 * @param int $id - Id of an article entry.
 * @return string
 */
function load_page_del(int $id): string
{
    $title = getContentsTitleById($id);

    $placeholderList = [
        '##placeholder-action##' => 'pagedel.php',
        '##placeholder-uri##'    => 'pages',
        '##placeholder-id##'     => $id,
        '##placeholder-title##'  => $title
    ];

    $template = getTemplate('adm_form_del');
    $template = strtr($template, $placeholderList);

    return $template;
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

    $page = getPage($id);

    if ($page['visibility'] == 'true') {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }

    $placeholderList = [
        '##placeholder-header##'   => '{edit_page}',
        '##placeholder-action##'   => 'pageupdate.php',
        '##placeholder-id##'       => $id,
        '##placeholder-title##'    => $page['title'],
        '##placeholder-tagline##'  => $page['tagline'],
        '##placeholder-content##'  => $page['text'],
        '##placeholder-datetime##' => strftime('%d.%m.%Y %H:%M', $page['datetime']),
        '##placeholder-chk_yes##'  => $chkYes,
        '##placeholder-chk_no##'   => $chkNo
    ];

    $template = getTemplate('adm_page_form');

    return strtr($template, $placeholderList);
}

/**
 * Load general overview of mainpage.
 *
 * @return string
 */
function load_mainpage() : string
{
    $contentList = getInfobox();

    $placeholderList = [
        '##placeholder-title##'   => $contentList['title'],
        '##placeholder-content##' => $contentList['text']
    ];

    $template = getTemplate('adm_mainpage');
    return strtr($template, $placeholderList);
}
