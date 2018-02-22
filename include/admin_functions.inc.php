<?php


/**
 *
 * @return string
 */
function load_admin_navigation(): string
{
    $template = '';
    
    $entries = countEntries();
    
    $placeholderList = [
        '<@placeholder_news@>' => $entries[0],
        '<@placeholder_downloads@>' => $entries[1],
        '<@placeholder_links@>' => $entries[2],
        '<@placeholder_articles@>' => $entries[3],
        '<@placeholder_sites@>' => $entries[4],
        '<@placeholder_trash@>' => $entries[5]
    ];
    
    $template = loadTemplate('adm_navigation');
    
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 *
 * @return string
 */
function load_admin_sidebar(): string
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
function load_admin_news(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();
    
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
    
    while($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $news->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y',$news->datetime) . '</td>';
        $table_content .= '<td>' . $news->title . '</td>';
        $table_content .= $news->visible > -1 ? '<td> ja</td>' : '<td> nein</td>';
        
        $table_content .= '<td>';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" .$news->id .">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" .$news->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
            
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsdel&id=" . $news->id .">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-delete.svg" title="{delete}"></a>';
        
        $table_content .= '</td>';
        $table_content .= '</tr>';
    }
    
    $template = str_replace('<@table_content@>', $table_content, $template);
    
    return $template;
}

/**
 * Formular zum Bearbeiten einer Nachricht laden
 * 
 * @param int $id
 * @return string
 */
function load_admin_news_edit(int $id): string
{
    $template = '';
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
        '<@id@>' => $result['id'],
        '<@title@>' => $result['title'],
        '<@message@>' => $result['message'],
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '@chk_yes@' => $chkYes,
        '@chk_no@' => $chkNo
    ];

    $template = loadTemplate('adm_news_edit');
    
    return strtr($template, $placeholderList);
}

/**
 * Formular zum Erstellen einer Nachricht laden
 * 
 * @return string
 */
function load_admin_news_add(): string
{
    $template = '';
    
    $placeholdeList = [
        '<@datetime@>' => StrFTime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_news_add');
    $template = strtr($template, $placeholdeList);
    
    return $template;
}

/**
 * Delete a news
 * 
 * @param int $id
 * @return string
 */
function load_admin_news_del(int $id): string
{
    $template = '';
    
    $title = getTitleFromTableById('news', $id);
    
    $placeholderList = [
        '<@id@>' => $id,
        '<@title@>' => $title
    ];
    
    $template = loadTemplate('adm_news_del');
    $template = strtr($template, $placeholderList);
    
    return $template;

}

/**
 * Gesamtübersicht der Downloads laden
 * 
 * @return string
 */
function load_admin_downloads(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();
    
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
        $table_content .= (($downloads->visible > - 1) ? '<td> ja</td>' : '<td>nein</td>');
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" .$downloads->id .">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot';
            
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsedit&id=" .$downloads->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
                
                
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=downloadsdel&id=" . $downloads->id .">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
    }
            
    $template = str_replace('<@downloads-content@>', $table_content, $template);

    return $template;
}

/**
 * Formular zum Bearbeiten eines Downloads laden
 * 
 * @param int $id
 * @return string
 */
function load_admin_downloads_edit(int $id): string
{
    $template = '';
    $chkNo  = '';
    $chkYes = '';
    
    $params = [
        $id
    ];
    
    $pdo = getPdoDB();
    
    $sql = 'SELECT `id`, `title`, `comment`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible`' 
        . " FROM `downloads` WHERE `id`=$id";
    
    $result = pdo_select($sql, $params);
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '<@id@>'       => $result['id'],
        '<@title@>'    => $result['title'],
        '<@path@>'     => $result['path'],
        '<@filename@>' => $result['filename'],
        '<@comment@>'  => $result['comment'],
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '@chk_yes@'    => $chkYes,
        '@chk_no@'     => $chkNo
    ];
    
    $template = loadTemplate('adm_downloads_edit');
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Formular zum Erstellen eines Downloads laden
 * 
 * @return string
 */
function load_admin_downloads_add(): string
{
    $template = '';
    $time = StrFTime('%d.%m.%Y %H:%M', time());
    
    $template .= loadTemplate('adm_downloads_add');
    $template = str_replace('<@time@>', $time, $template);
    
    return $template;
}

/**
 * Download löschen
 * 
 * @param int $id
 * @return string
 */
function load_admin_downloads_del(int $id): string
{
    $title = getTitleFromTableById('downloads', $id);
    
    $placeholderList = [
        '<@id@>' => $id,
        '<@title@>' => $title
    ];
    
    $template = loadTemplate('adm_downloads_del');
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Gesamtübersicht der Links laden
 * 
 * @return string
 */
function load_admin_links(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();

    $template = loadTemplate('adm_links');

    $sql = 'SELECT `id`, `title`, `uri`, UNIX_TIMESTAMP(`created_at`) as datetime, `visible`'
        . " FROM `links` WHERE `trash` = 'false' ORDER BY `title` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    while($link = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $link->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y',$link->datetime) . '</td>';
        $table_content .= '<td>' . $link->title . '</td>';
        $table_content .= $link->visible > -1 ? '<td> ja</td>' : '<td> nein</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=". $link->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=". $_SERVER['PHP_SELF'] . "?uri=linkdel&id=" . $link->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        $table_content .= '</tr>';
    }
    
    $template = str_replace('<@links-content@>', $table_content, $template);
    
    return $template;
}

/**
 * Formular zum Bearbeiten eines Links laden
 * 
 * @param int $id
 * @return string
 */
function load_admin_link_edit(int $id): string
{
    $template = '';
    $chkYes = '';
    $chkNo = '';
    
    $params = [
        $id
    ];
    
    $sql = "SELECT `id`, `title`, `uri`, `comment`, `visible` FROM `links` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '<@id@>'       => $result['id'],
        '<@title@>'    => $result['title'],
        '<@uri@>'      => $result['uri'],
        '<@comment@>'  => $result['comment'],
        '@chk_yes@'    => $chkYes,
        '@chk_no@'     => $chkNo
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
function load_admin_link_add(): string
{
    $template = '';
    
    $template = loadTemplate('adm_link_add');
    
    return $template;
}


/**
 * Link löschen
 * 
 * @param int $id
 * @return string
 */
function load_admin_link_del(int $id): string
{
    $template = '';
    
    $title = getTitleFromTableById('links', $id);
    
    $placeholderList = [
        '<@id@>' => $id,
        '<@title@>' => $title
    ];
    
    $template = loadTemplate('adm_link_del');
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Load general overview of all articles
 * 
 * @return string
 */
function load_admin_articles(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();
    
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
        $table_content .= '<td>' . strftime('%d.%m.%Y',$article->datetime) . '</td>';
        $table_content .= '<td>' . $article->title . '</td>';
        $table_content .= '<td>' . $article->visible > -1 ? '<td> ja</td>' : '<td> nein</td>' . '</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articledel&id=" . $article->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $table_content .= '</tr>';
    }

    $template = str_replace('<@articles-content@>', $table_content, $template);

    return $template;
}

/**
 * Formular zum Bearbeiten eines Artikels laden
 * 
 * @param int $id
 * @return string
 */
function load_admin_article_edit(int $id): string
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
        '<@id@>' => $result['id'],
        '<@title@>' => $result['title'],
        '<@content@>' => $result['content'],
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '@chk_yes@' => $chkYes,
        '@chk_no@' => $chkNo
    ];
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * Formular zum Erstellen eines Artikels laden
 * 
 * @return string
 */
function load_admin_article_add(): string
{
    $template = '';
    
    $template = loadTemplate('adm_article_add');
    
    $placeholderList = [
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', time())
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
function load_admin_article_del(int $id): string
{
    $template = '';
    
    $title = getTitleFromTableById('articles', $id);
    
    $placeholderList = [
        '<@id@>' => $id,
        '<@title@>' => $title
    ];
    
    $template = loadTemplate('adm_article_del');
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 *
 * @return string
 */
function load_dashboard(): string
{
    $template = '';
    
    $template = loadTemplate('adm_dashboard');
    
    return $template;
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
    
    $template = loadTemplate('adm_trash');
    
    return $template;
}

/**
 *
 * @return string
 */
function load_general_settings(): string
{    
    $template = loadTemplate('adm_general_settings');

    $placeholderList = [
        '<@placeholder-title@>' => $_SESSION['title'],
        '<@placeholder-tagline@>' => $_SESSION['tagline'],
        '<@placeholder-blog-url@>' => $_SESSION['blog-url'],
        '<@placeholder-option-theme@>' => load_theme_options()
    ];
    
    $template = strtr($template, $placeholderList);

    return $template;
}

/**
 * 
 * @return string
 */
function load_theme_options() : string {
    
    $html = '';
    
    $template_dir = __DIR__ . '/../templates/';
    
    $files = scandir($template_dir);

    for($i = 2; $i <= count($files) - 1; $i++) {
        if ( $files[$i] === $_SESSION['theme']) {
            $select = ' selected';
        } else {
            $select = '';
        }
        
        $html .= "<option $select>$files[$i]</option>";
    }
    
    return $html;
}

/**
 *
 * @return string
 */
function load_user_list(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();
    
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
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
            
        $table_content .= " <a href=" . $_SERVER['PHP_SELF'] . "?uri=userdel&id=" . $user->id . ">"
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $table_content .= '</tr>';
         
    }
    
    $template = str_replace('<@user_list_content@>', $table_content, $template);
    
    return $template;
}

/**
 *
 * @param int $id
 * @return string
 */
function load_user_edit(int $id): string
{
    $template = '';
    $chkNo = '';
    $chkYes = '';
    
    $params = [
        $id
    ];
    
    $template = loadTemplate('adm_user_edit');
    
    $sql = 'SELECT `id`, `firstname`, `lastname` ,`email`, `password`, UNIX_TIMESTAMP(`created_at`) AS datetime, `updated_at`, `username`, `active`' 
        . ' FROM `users`' . ' WHERE `id` = ?';
    
    $user = pdo_select($sql, $params);
    
    if ( strcmp($user['active'], 'true') === 0) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '<@id@>' => $user['id'],
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', $user['datetime']),
        '<@firstname@>' => $user['firstname'],
        '<@lastname@>' => $user['lastname'],
        '<@username@>' => $user['username'],
        '<@email@>' => $user['email'],
        '<@public_as@>' => $user['username'],
        '@chk_yes@' => $chkYes,
        '@chk_no@' => $chkNo
    ];
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * 
 * @return string
 */
function load_user_add(): string
{
    $template = '';
    
    $placeholderList = [
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_user_insert');
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * 
 * @param unknown $id
 * @return string
 */
function load_user_del($id)
{
    $template = '';
    $placeholderList = [];
    
    $title = getUsernameById($id);

    $placeholderList = [
        '<@id@>' => $id,
        '<@title@>' => $title
    ];
    
    $template = loadTemplate('adm_user_del');
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * 
 * @return string
 */
function load_admin_sites() : string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();
    
    $template = loadTemplate('adm_sites');
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`'
        . " FROM `sites` WHERE `trash` = 'false' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
    while ($site = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $site->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y', $site->datetime) . '</td>';
        $table_content .= '<td>' . $site->title . '</td>';
        $table_content .= '<td>' . $site->visible > - 1 ? '<td> ja</td>' : '<td> nein</td>' . '</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=siteedit&id=" . $site->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-edit.svg" title="{edit}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=siteedit&id=" . $site->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-document-copy.svg" title="{copy}"></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=sitedel&id=" . $site->id . ">" 
            . '<img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-delete.svg" title="{delete}"></a></td>';
        
        $table_content .= '</tr>';
    }
    
    $template = str_replace('<@sites-content@>', $table_content, $template);
    
    return $template;
}

/**
 * 
 * @return string
 */
function load_admin_site_add() : string
{
    $template = '';
    
    $placeholdeList = [
        '<@datetime@>' => StrFTime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = loadTemplate('adm_site_add');
    $template = strtr($template, $placeholdeList);
    
    return $template;
}

/**
 * 
 * @param int $id
 * @return string
 */
function load_admin_site_edit(int $id) : string
{
    $template = '';
    $params = [
        $id
    ];
    $chkNo = '';
    $chkYes = '';
    
    $sql = "SELECT `id`, `title`, `tagline`, `content`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `sites` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    $template = loadTemplate('adm_site_edit');
    
    if ($result['visible'] > - 1) {
        $chkYes = ' checked';
    } else {
        $chkNo = ' checked';
    }
    
    $placeholderList = [
        '<@id@>' => $result['id'],
        '<@title@>' => $result['title'],
        '<@tagline@>' => $result['tagline'],
        '<@content@>' => $result['content'],
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '@chk_yes@' => $chkYes,
        '@chk_no@' => $chkNo
    ];
    
    $template = strtr($template, $placeholderList);
    
    return $template;
}

/**
 * 
 * @return string
 */
function load_admin_mainpage()
{
    return loadTemplate('mainpage');    
}

/*
 * *******************************************************************************
 * SQL - section
 * ******************************************************************************
 */

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
    $pdo = getPdoDB();
    
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
        exit();
        
    }
    
    return $stmt->fetchAll();
}

/**
 * Get title from a table by id
 *
 * @param string $table - Name of a table
 * @param int $id       - Id
 *            
 * @return string
 */
function getTitleFromTableById(string $table, int $id)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `title` FROM `$table` WHERE `id` = :id";
    
    $input_parameters = [
        ':id'    => $id
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
 * Get title from a table by id
 *
 * @param string $table - Name of a table
 * @param int $id       - Id
 *
 * @return string
 */
function getUsernameById(int $id)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `username` FROM `users` WHERE `id` = :id";
    
    $input_parameters = [
        ':id'    => $id
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
    $pdo = getPdoDB();
    
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
    $pdo = getPdoDB();
    
    $sql = "UPDATE `$table` SET `trash`='true' WHERE `id`= :id";
    
    try {
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $id));
        
    } catch (PDOException $ex) {
        
        echo $ex->getMessage();
        exit();
        
    }
}
