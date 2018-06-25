<?php

/**
 * Database connection for heinerCMS that use PDO-Connection.
 * 
 * @param string $driver Driver can be mysql or sqlite.
 * 
 * @return PDO
 */
function getPdoConnection() : PDO
{
    try {

        if ( DB_DRIVER == 'mysql') {
            $pdo = new PDO( DB_DRIVER . ':host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD );
        } else {
            $pdo = new PDO(DB_DRIVER . ':' . DB_NAME);
        }

        if ( PDO_DEBUG_MODE ) {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $pdo;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

}

/**
 * Formats the time for mysql or sqlite.
 * 
 * @return string
 */
function datetimeFormater() : string
{
    $datetime = 'UNIX_TIMESTAMP(`created_at`) AS datetime';

    if (DB_DRIVER == 'sqlite') {
        $datetime = "strftime('%s', `created_at`) AS datetime";
    }

    return $datetime;
}

/**
 * 
 * @return PDOStatement
 */
function loadNewsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() . ', `visibility`'
    . " FROM `news` WHERE `trash` = 'false' ORDER BY `created_at` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param int $id
 * @return PDOStatement
 */
function loadNewsDetailedStatement(int $id) : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `title`, `message`, ' . datetimeFormater() . ' FROM `news` WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

function loadNewsEditStatement(int $id)
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`, `message`, ' . datetimeFormater() . ', `visibility`'
        . ' FROM `news` WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadPublicNewsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $datetime = 'UNIX_TIMESTAMP(news.created_at) AS datetime';

    if (DB_DRIVER == 'sqlite') {
        $datetime = "strftime('%s', news.created_at) AS datetime";
    }

    $sql = "SELECT news.id, news.title, news.message, $datetime,
        news_settings.tagline as news_tagline, news_settings.comment as news_comment
        FROM `news`, `news_settings`
        WHERE `visibility` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Add news entry.
 * 
 * @param string $title
 * @param string $message
 * @param string $visible
 * 
 * @since 0.3.0
 */
function addNews(string $title, string $message, string $visible)
{
    $sql = "INSERT INTO `news` (`title`, `message`, `visibility`)
        VALUES (:title, :message, :visibility)";
    
    if (DB_DRIVER == 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';
        
        $sql = "INSERT INTO `news` (`title`, `message`, `created_at`, `visibility`, `trash`)
            VALUES (:title, :message, :created_at, :visibility, :trash)";
    }
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':visibility', $visible);
        
        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update news entry.
 * 
 * @param int $id
 * @param string $title
 * @param string $message
 * @param string $visible
 * 
 * @since 0.3.0
 */
function updateNews(int $id, string $title, string $message, string $visible)
{
    $pdo = getPdoConnection();
    
    $sql = "UPDATE `news` SET `title` = :title, `message` = :message, `visibility` = :visibility WHERE `id` = :id";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':visibility', $visible);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute($inpuit_parameters);
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param string $tagline
 * @param string $comment
 */
function updateNewsSettings(string $tagline, string $comment)
{
    $sql = "UPDATE `news_settings` SET `tagline`= :tagline,`comment`= :comment WHERE 1";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);
        
        $stmt->execute($input_parameters);
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() . ', `path`, `filename`, `visibility`'
        . " FROM `downloads` WHERE `trash` = 'false' ORDER BY `created_at` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param int $id
 * @return mixed
 */
function loadDownloadsEditStatement(int $id)
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`, `comment`, ' . datetimeFormater() . ', `path`, `filename`, `visibility`'
        . ' FROM `downloads` WHERE `id`= :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadDownloadsSettingsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "SELECT `tagline`, `comment` FROM `downloads_settings` WHERE `id` = 1";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadPublicDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $datetime = 'UNIX_TIMESTAMP(downloads.created_at) AS datetime';

    if (DB_DRIVER == 'sqlite') {
        $datetime = "strftime('%s', downloads.created_at) AS datetime";
    }

    $sql = "SELECT downloads.title, downloads.comment, downloads.path, downloads.filename, $datetime,
        downloads_settings.tagline as downloads_tagline, downloads_settings.comment as downloads_comment
        FROM `downloads`, `downloads_settings`
        WHERE `visibility` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Add a download.
 * 
 * @param string $title
 * @param string $comment
 * @param string $path
 * @param string $filename
 * @param string $visible
 * 
 * @since 0.3.0
 */
function addDownload(string $title, string $comment, string $path, string $filename, string $visible)
{
    $sql = "INSERT INTO `downloads` (`title`, `comment`, `path`, `filename`, `visibility`)
        VALUES (:title, :comment, :path, :filename, :visibility)";
    
    if ( DB_DRIVER == 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';
        
        $sql = "INSERT INTO `downloads` (`title`, `comment`, `path`, `filename`, `created_at`, `visibility`, `trash`)
            VALUES (:title, :comment, :path, :filename, :created_at, :visibility, :trash)";
    }
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visibility', $visible);
        
        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update download entry.
 * 
 * @param string $title
 * @param string $comment
 * @param string $path
 * @param string $filename
 * @param string $visible
 * 
 * @since 0.3.0
 */
function updateDownload(int $id, string $title, string $comment, string $path, string $filename, string $visible)
{
    $pdo = getPdoConnection();
    
    $sql = "UPDATE `downloads` SET `title` = :title, 
        `comment` = :comment, 
        `path` = :path, 
        `filename` = :filename, 
        `visibility` = :visibility
        WHERE `id` = :id";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visibility', $visible);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute($input_parameters);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param string $tagline
 * @param string $comment
 */
function updateDownloadsSettings(string $tagline, string $comment)
{
    $sql = "UPDATE `downloads_settings` SET `tagline`= :tagline,`comment`= :comment WHERE 1";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);
        
        $stmt->execute($input_parameters);
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadLinksStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`, `uri`,' . datetimeFormater() . ', `visibility`'
        . " FROM `links` WHERE `trash` = 'false' ORDER BY `title` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param int $id
 * @return mixed
 */
function loadLinksEditStatement(int $id)
{
    $pdo = getPdoConnection();

    $sql = "SELECT `id`, `title`, `tagline`, `uri`, `comment`, `visibility` FROM `links` WHERE `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

}

/**
 * 
 * @return PDOStatement
 */
function loadPublicLinksStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $datetime = 'UNIX_TIMESTAMP(links.created_at) AS datetime';
    
    if (DB_DRIVER == 'sqlite') {
        $datetime = "strftime('%s', links.created_at) AS datetime";
    }

    $sql = "SELECT links.title, links.tagline, links.uri, links.comment, $datetime,
        links_settings.tagline as settings_tagline, links_settings.comment as settings_comment
        FROM `links`, `links_settings`
        WHERE `visibility` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

}

/**
 * Add link entry.
 * 
 * @param string $title
 * @param string $tagline
 * @param string $comment
 * @param string $uri
 * @param string $visible
 * 
 * @since 0.3.0
 */
function addLink(string $title, string $tagline, string $comment, string $uri, string $visible)
{
    $sql = "INSERT INTO `links` (`title`, `tagline`, `uri`, `comment`, `visibility`)
        VALUES (:title, :tagline, :uri, :comment, :visibility)";
    
    if( DB_DRIVER == 'sqlite' ) {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';
        
        $sql = "INSERT INTO `links` (`title`, `tagline`, `uri`, `comment`, `created_at`, `visibility`, `trash`)
        VALUES (:title, :tagline, :uri, :comment, :created_at, :visibility, :trash)";
    }
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visible);
        
        if ( DB_DRIVER == 'sqlite' ) {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update a link entry.
 * 
 * @param int $id
 * @param string $title
 * @param string $comment
 * @param string $uri
 * @param string $visible
 * 
 * @since 0.3.0
 */
function updateLink(int $id, string $title, string $comment, string $uri, string $visible)
{
    $sql = "UPDATE `links` SET `title` = :title, `comment` = :comment, `uri` = :uri, `visibility` = :visibility WHERE `id` = :id";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visible);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param string $tagline
 * @param string $comment
 * 
 * @since 0.3.0
 */
function updateLinksSettings(string $tagline, string $comment)
{
    $sql = "UPDATE `links_settings` SET `tagline`= :tagline,`comment`= :comment WHERE 1";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);
        
        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadArticlesStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() .', `visibility`'
        . " FROM `articles` WHERE `trash` = 'false' ORDER BY `created_at` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param int $id
 * @return PDOStatement
 */
function loadArticlesDetailedStatement(int $id) : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `title`, `content`, ' . datetimeFormater() . ' FROM `articles` WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Add a new article.
 * 
 * @param string $title
 * @param string $content
 * @param string $visible
 * 
 * @since 0.3.0
 */
function addArticle(string $title, string $content, string $visible)
{
    $sql = "INSERT INTO `articles` (`title`, `content`, `visibility`) VALUES (:title, :content, :visibility)";
    
    if(DB_DRIVER === 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';
        
        $sql = "INSERT INTO `articles` (`title`, `content`, `created_at`, `visibility`, `trash`)
            VALUES (:title, :content, :created_at, :visibility, :trash)";
    }
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':visibility', $visible);
        
        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }
        
        $stmt->execute($input_parameters);
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update a article by id.
 * 
 * @param int $id
 * @param string $title
 * @param string $content
 * @param string $visibility
 * 
 * @since 0.3.0
 */
function updateArticle(int $id, string $title, string $content, string $visibility)
{
    $pdo = getPdoConnection();
    
    $sql = "UPDATE `articles` SET `title` = :title, `content` = :content, `visibility` = :visibility WHERE `id` = :id";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param string $tagline
 * @param string $comment
 */
function updateArticleSettings(string $tagline, string $comment)
{
    $sql = "UPDATE `articles_settings` SET `tagline`= :tagline,`comment`= :comment WHERE 1";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);
        
        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadPublicArticlesStatement() : PDOStatement
{
    $datetime = 'UNIX_TIMESTAMP(articles.created_at) AS datetime';

    if (DB_DRIVER == 'sqlite') {
        $datetime = "strftime('%s', articles.created_at) AS datetime";
    }

    $sql = "SELECT articles.id, articles.title, articles.content, $datetime,
        articles_settings.tagline as tagline, articles_settings.comment as comment
        FROM `articles`, `articles_settings`
        WHERE `visibility` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

    $pdo = getPdoConnection();

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
         echo $ex->getMessage();
         exit();
    }
}

/**
 * 
 * @param int $id
 * @return mixed
 */
function loadArticlesEditStatement(int $id)
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`, `content`, ' . datetimeFormater() . ', `visibility` FROM `articles` WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadPagesStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() . ', `visibility`'
        . " FROM `sites` WHERE `trash` = 'false' ORDER BY `created_at` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

function loadPageEditStatement(int $id)
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`, `tagline`, `content`, ' .datetimeFormater() . ', `visibility` FROM `sites` WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Add page.
 * 
 * @param string $title
 * @param string $tagline
 * @param string $content
 * @param string $visible
 * 
 * @since 0.3.0
 */
function addPage(string $title, string $tagline, string $content, string $visible)
{
    $sql = "INSERT INTO `sites` (`title`, `tagline`, `content`, `visibility`)
        VALUES (:title, :tagline, :content, :visibility)";
    
    if (DB_DRIVER == 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';
        
        $sql = "INSERT INTO `sites` (`title`, `tagline`, `content`, `created_at`, `visibility`, `trash`)
            VALUES (:title, :tagline, :content, :created_at, :visibility, :trash)";
    }
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':visibility', $visible);
        
        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }
        
        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
    
}

/**
 * Update page entry.
 * 
 * @param int $id
 * @param string $title
 * @param string $content
 * @param string $visibility
 * 
 * @since 0.3.0
 */
function updatePage(int $id, string $title, string $tagline, string $content, string $visibility)
{
    $pdo = getPdoConnection();

    $sql = 'UPDATE `sites` SET `title` = :title, `tagline` = :tagline, `content` = :content, `visibility` = :visibility WHERE `id` = :id';
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

function loadUserStatement()
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`,`firstname`,`lastname`,`username`,`active`'
        . ' FROM `users` ORDER BY `firstname` DESC';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

function loadUserEditStatement(int $id)
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `firstname`, `lastname` ,`email`, `password`, ' .datetimeFormater(). ', `username`, `active`'
        . ' FROM `users`' . ' WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
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

    $sql = 'SELECT `id`, `title`, ' . datetimeFormater() 
        . " FROM `$table` WHERE `trash` = 'true' ORDER BY `created_at` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * 
 * @param string $title
 * @param string $tagline
 * @param string $theme
 * @param string $blogUrl
 * @param string $language
 * @param string $footer
 */
function updateGeneralSettings(string $title, string $tagline, string $theme, string $blogUrl, string $language, string $footer)
{
    $sql = 'UPDATE `settings` SET `title`=:title,
        `tagline`=:tagline,
        `theme`=:theme,
        `blog_url`=:blog_url,
        `lang_short`=:language,
        `footer`=:footer WHERE 1';
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':blog_url', $blogUrl);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':footer', $footer);
        
        $stmt->execute();
    } catch (Exception $ex) {
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
 * @param int $id
 * @param string $table
 */
function setFlagTrashById(int $id, string $table)
{
    $pdo = getPdoConnection();

    $sql = "UPDATE `$table` SET `trash`='true' WHERE `id`= :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Get title from a table by id
 *
 * @param string $table - Name of a table
 * @param int $id - Id
 *
 * @return string
 */
function getTitleFromTableById(string $table, int $id)
{
    $pdo = getPdoConnection();

    $sql = "SELECT `title` FROM `$table` WHERE `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

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

        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

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

    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visibility`'
        . " FROM `$table` WHERE `trash` = 'false' ORDER BY `created_at` DESC LIMIT $count";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
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

    $sql = 'SELECT `username` FROM `users` WHERE `id` = :id';

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}