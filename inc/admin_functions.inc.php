<?php

/**
 *  Überprüft, ob ein Login erfolgt ist 
 */
function is_logged_in()
{
    session_start();
    
    include __DIR__ . '/base.inc.php';
    $PHP_SELF = $_SERVER['PHP_SELF'];
    
    $authenticated = isset($_SESSION['authenticated']) ? true : false;
    
    load_session();
    
    /* User angemeldet? */
    if ($authenticated) {
        return true;
    } else {
        $login = loadTemplate('adm_login');
        $template = loadTemplate('login_template');
        
        $template = str_replace('<@title@>', $base['adm_title'], $template);
        $template = str_replace('<@shortnav@>', '&nbsp;', $template);
        $template = str_replace('<@navigation@>', '&nbsp;', $template);
        $template = str_replace('<@content@>', $login, $template);
        $template = str_replace('$PHP_SELF', $PHP_SELF, $template);
        
        echo stripslashes($template);
        
        return false;
    }
}

/**
 */
function load_session()
{
    $config = __DIR__ . '/../source/configs/config.ini';
    
    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);
        
        $_SESSION['title'] = $ini_array['title'];
        $_SESSION['theme'] = $ini_array['theme'];
    }
}

/**
 *
 * @return string
 */
function load_admin_navigation(): string
{
    $template = '';
    
    $template = loadTemplate('adm_navigation');
    
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
    }
    
    while($news = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $news->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y',$news->datetime) . '</td>';
        $table_content .= '<td>' . $news->title . '</td>';
        $table_content .= $news->visible > -1 ? '<td> ja</td>' : '<td> nein</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" .$news->id .">"
            . '<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsedit&id=" .$news->id . ">"
            . '<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot;';
        
            
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=newsdel&id=" . $news->id .">"
            . '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>';
        
        $table_content .= '</tr>';
    }
    
    $template = str_replace('<@table_content@>', $table_content, $template);
    
    return $template;
}

/* Formular zum Bearbeiten einer Nachricht laden */
/**
 *
 * @param int $id
 * @return string
 */
function load_admin_news_edit(int $id): string
{
    $template = '';
    $params = [
        $id
    ];
    
    $sql = "SELECT `id`, `title`, `message`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible` FROM `news` WHERE `id` = $id";
    
    $pdo = getPdoDB();
    
    $template = loadTemplate('adm_news_edit');
    
    return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
/**
 *
 * @return string
 */
function load_admin_news_add(): string
{
    $template = '';
    
    $time = StrFTime('%d.%m.%Y %H:%M', time());
    $template = loadTemplate('adm_news_add');
    
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
    $arr = [];
    
    $title = getTitleFromTableById('news', $id);
    
    $arr = [
        'id' => $id,
        'title' => $title
    ];
    
    $template = loadTemplate('adm_news_del');
    
    return $template;
}

/* Gesamtübersicht der Downloads laden */
/**
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
    }
       
    while ($downloads = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . StrFTime('%d.%m.%Y %H:%M', $downloads->datetime) . '</td>';
        $table_content .= '<td>' . $downloads->title . '</td>';
        $table_content .= (($downloads->visible > - 1) ? '<td> ja</td>' : '<td>nein</td>');
        $table_content .= "<td><a href=\"$_SERVER[PHP_SELF]?uri=downloadsedit&id=$downloads->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=downloadsdel&id=$downloads->id\">Löschen</a></tr>";
    }
            
    $template = str_replace('<@downloads-content@>', $table_content, $template);

    return $template;
}

/* Formular zum Bearbeiten eines Downloads laden */
/**
 *
 * @param int $id
 * @return string
 */
function load_admin_downloads_edit(int $id): string
{
    $template = '';
    
    $con = getPdoDB();
    
    if ($con) {
        
        $sql = 'SELECT `id`, `title`, `comment`, UNIX_TIMESTAMP(`created_at`) AS datetime, `path`, `filename`, `visible`' 
            . " FROM `downloads` WHERE `id`=$id";
        $result = mysqli_query($con, $sql);
        
        if ($result) {
            $downloads = mysqli_fetch_object($result);
            
            $template = loadTemplate('downloadsedit');
        }
        mysqli_close($con);
    }
    return $template;
}

/* Formular zum Erstellen eines Downloads laden */
/**
 *
 * @return string
 */
function load_admin_downloads_add(): string
{
    $template = '';
    $time = StrFTime('%d.%m.%Y %H:%M', time());
    
    $template .= loadTemplate('adm_downloads_add');
    $template = str_replace('###time###', $time, $template);
    
    return $template;
}

/* Download löschen */
/**
 *
 * @param int $id
 * @return string
 */
function load_admin_downloads_del(int $id): string
{
    $title = getTitleFromTableById('downloads', $id);
    
    $container = [
        'id' => $id,
        'title' => $title
    ];
    
    $template = loadTemplate('adm_downloads_del');
    
    return $template;
}

/* Gesamtübersicht der Links laden */
/**
 *
 * @return string
 */
function load_admin_links(): string
{
    $template = '';
    $table_content = '';
    
    $pdo = getPdoDB();

    $template = loadTemplate('adm_links');

    $sql = "SELECT `id`, `title`, `uri`, UNIX_TIMESTAMP(`created_at`) as datetime, `visible` FROM `links` WHERE `trash` = 'false' ORDER BY `title` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit;
    }

    while($link = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $link->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y',$link->datetime) . '</td>';
        $table_content .= '<td>' . $link->title . '</td>';
        $table_content .= $link->visible > -1 ? '<td> ja</td>' : '<td> nein</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=". $link->id . ">"
            . '<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=linkedit&id=" . $link->id . ">"
            . '<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot;';
        
        $table_content .= "<a href=". $_SERVER['PHP_SELF'] . "?uri=linkdel&id=" . $link->id . ">"
            . '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>';
        $table_content .= '</tr>';
    }
    
    /*<?php while ($link = mysqli_fetch_object ( $result ) ) : ?>
				<tr>
					<td><?= $link->id; ?></td>
					<td><?= $link->title; ?></td>
					<td><?= ($link->visible > -1) ? ' ja' : ' nein'; ?></td>
					<td><a href="<?= "$_SERVER[PHP_SELF]?uri=linkedit&id=$link->id"; ?>">
							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot; 
						<a href="<?= "$_SERVER[PHP_SELF]?uri=linkedit&id=$link->id"; ?>">
							<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot; 
						<a href="<?= "$_SERVER[PHP_SELF]?uri=linkdel&id=$link->id"; ?>">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
				</tr>
				<?php endwhile; ?>*/
    
    $template = str_replace('<@links-content@>', $table_content, $template);
    
    return $template;
}

/* Formular zum Bearbeiten eines Links laden */
/**
 *
 * @param int $id
 * @return string
 */
function load_admin_link_edit(int $id): string
{
    $template = '';
    $params = [
        $id
    ];
    
    $sql = "SELECT `id`, `title`, `uri`, `comment`, `visible` FROM `links` WHERE `id` = $id";
    
    $result = pdo_select($sql, $params);
    
    $template = loadTemplate('adm_link_edit');
    
    return $template;
}

/* Formular zum Erstellen einer Nachricht laden */
/**
 *
 * @return string
 */
function load_admin_link_add(): string
{
    $template = '';
    
    $template = loadTemplate('adm_link_add');
    
    return $template;
}

/* Link löschen */
/**
 *
 * @param int $id
 * @return string
 */
function load_admin_link_del(int $id): string
{
    $template = '';
    $container = [];
    
    $title = getTitleFromTableById('links', $id);
    
    $container = [
        'id' => $id,
        'title' => $title
    ];
    
    $template = loadTemplate('adm_link_del');
    
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
    }
    
    while ($article = $stmt->fetch(PDO::FETCH_OBJ)) {
        $table_content .= '<tr>';
        $table_content .= '<td>' . $article->id . '</td>';
        $table_content .= '<td>' . strftime('%d.%m.%Y',$article->datetime) . '</td>';
        $table_content .= '<td>' . $article->title . '</td>';
        $table_content .= '<td>' . $article->visible > -1 ? '<td> ja</td>' : '<td> nein</td>' . '</td>';
        
        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">"
            . '<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articleedit&id=" . $article->id . ">"
            . '<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot;';
        
        $table_content .= "<a href=" . $_SERVER['PHP_SELF'] . "?uri=articledel&id=" . $article->id . ">"
            . '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>';
        
        $table_content .= '</tr>';
    }

    $template = str_replace('<@articles-content@>', $table_content, $template);

    return $template;
}

/* Formular zum Bearbeiten eines Artikels laden */
/**
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
    }
    
    if ($result['visible'] < 0) {
        $chkNo = ' checked';
    }
    
    $arr = [
        '<@id@>' => $result['id'],
        '<@title@>' => $result['title'],
        '<@content@>' => $result['content'],
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', $result['datetime']),
        '@chk_yes@' => $chkYes,
        '@chk_no@' => $chkNo
    ];
    
    $template = strtr($template, $arr);
    
    return $template;
}

/* Formular zum Erstellen eines Artikels laden */
/**
 *
 * @return string
 */
function load_admin_article_add(): string
{
    $template = '';
    
    $template = loadTemplate('adm_article_add');
    
    $arr = [
        '<@datetime@>' => strftime('%d.%m.%Y %H:%M', time())
    ];
    
    $template = strtr($template, $arr);
    
    return $template;
}

/* Artikel löschen */
/**
 *
 * @param int $id
 * @return string
 */
function load_admin_article_del(int $id): string
{
    $template = '';
    $container = [];
    
    $title = getTitleFromTableById('articles', $id);
    
    $content = [
        '<@id@>' => $id,
        '<@title@>' => $title
    ];
    
    $template = loadTemplate('adm_article_del');
    
    $template = strtr($template, $content);
    
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
    
    $news = loadFromTable('news', 5);
    $articles = loadFromTable('articles', 5);
    $links = loadFromTable('links', 5);
    $downloads = loadFromTable('downloads', 5);
    
    $arr = [
        '<@news_content@>' => renderHtmlTable($news),
        '<@downloads_content@>' => renderHtmlTable($downloads),
        '<@links_content@>' => renderHtmlTable($links),
        '<@articles_content@>' => renderHtmlTable($articles)
    ];
    
    $template = strtr($template, $arr);
    
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
    $content = [];
    
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
    $template_dir = __DIR__ . '/../templates/';
    $option = '';
    
    $template = loadTemplate('adm_general_settings');
    
    $tmp = scandir($template_dir);
    
    foreach ($tmp as $theme) {
        $option .= "<option>$theme</option>";
    }

    $template = str_replace('<@theme-placeholder@>', $option, $template);

    return $template;
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
    $sql = 'SELECT `id`,`firstname`,`lastname`,`username`,`active`' . ' FROM `users` ORDER BY `firstname` DESC';
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    while ($user = $stmt->fetch(PDO::FETCH_OBJ)) {
        
        $table_content .= '<tr><td>' . $user->id . '</td>';
        $table_content .= '<td>' . $user->firstname . '</td>';
        $table_content .= '<td>' . $user->lastname . '</td>';
        $table_content .= '<td>' . $user->username . '</td>';
        $table_content .= '<td>' . $user->active . '</td>';

        $table_content .= "<td><a href=" . $_SERVER['PHP_SELF'] . "?uri=useredit&id=" . $user->id . ">"
         . "<span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\" title=\"Edit\"></span></a> &middot;";
        $table_content .= " <a href=" . $_SERVER['PHP_SELF'] . "?uri=userdel&id=" . $user->id . ">"
         . "<span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></a></td></tr>";
         
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
    $params = [
        $id
    ];
    
    $template = loadTemplate('adm_user_edit');
    
    $sql = 'SELECT `id`,`firstname`,`lastname`,`email`,`password`,`created_at`,`updated_at`,`username`,`active`' . ' FROM `users`' . ' WHERE `id` = ?';
    
    $user = pdo_select($sql, $params);
    
    $arr = [
        '<@id@>' => $user['id'],
        '<@datetime@>' => '',
        '<@firstname@>' => $user['firstname'],
        '<@lastname@>' => $user['lastname'],
        '<@username@>' => $user['username'],
        '<@email@>' => $user['email'],
        '<@public_as@>' => $user['username']
    ];
    
    $template = strtr($template, $arr);
    
    return $template;
}

function load_user_insert(): string
{
    $template = '';
    
    $template = loadTemplate('adm_user_insert');
    
    return $template;
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
        SELECT COUNT(*) as result
                FROM (
                SELECT `trash` FROM `articles`
                UNION ALL
                SELECT `trash` FROM `news`
                UNION ALL
                SELECT `trash` FROM `downloads`
                UNION ALL
                SELECT `trash` FROM `links`
                ) as subquery
                WHERE `trash` = 'true';";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
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
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`' . " FROM `$table` WHERE `trash` = 'false' ORDER BY `created_at` DESC LIMIT $count";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
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
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime' . " FROM `$table` WHERE `trash` = 'true' ORDER BY `created_at` DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    
    return $stmt->fetchAll();
}

/**
 * Get title from a table by id
 *
 * @param string $table
 *            - Name of the Table
 * @param int $id
 *            - Id
 *            
 * @return string
 */
function getTitleFromTableById(string $table, int $id)
{
    $pdo = getPdoDB();
    
    $sql = "SELECT `title` FROM `$table` WHERE `id` = $id";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
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
    
    $sql = "DELETE FROM `$table` WHERE `trash` = 'true'";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
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
    
    $sql = "UPDATE `$table` SET `trash`='true' WHERE `id`= $id";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
