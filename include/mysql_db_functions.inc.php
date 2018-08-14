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
        $pdo = new PDO( DB_DRIVER . ':host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD );
        
        if ( PDO_DEBUG_MODE ) {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return $pdo;
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
}

function normalize(int $id, string $table)
{
    $sql = "
    SELECT COUNT(`id`) 
    FROM `$table`
    ";
    
    if ($id <= 0 && $id > count($result)) {
        // @todo: entry not found
    }
    
    return $id;
}

/**
 * 
 * @return PDOStatement
 * 
 * @since 0.8.0
 */
function loadDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `path`, 
        `filename`, 
        `visibility`
        FROM `contents` 
        WHERE `content_type` = 'download' 
            AND `flag` = ''
            ORDER BY `created_at` DESC
    ";

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
 * Get a download entry from table 'downloads' by id.
 * 
 * @param int $id - Id of a download entry.
 * @return array  - List of a download entry.
 * 
 * @since 0.8.0
 */
function getDownloads(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `text`, 
        `path`, 
        `filename`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility`
        FROM `contents` 
        WHERE `content_type` = 'download'
            AND `id`= :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_NUM);
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

    $sql = '
    SELECT `tagline`, 
        `comment` 
        FROM `downloads_settings` 
        WHERE `id` = 1
    ';

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

    $sql = "
    SELECT downloads.title, 
        downloads.comment, 
        downloads.path, 
        downloads.filename, 
        UNIX_TIMESTAMP(downloads.created_at) AS datetime,
        downloads_settings.tagline as downloads_tagline, 
        downloads_settings.comment as downloads_comment
        FROM `downloads`, `downloads_settings`
        WHERE `visibility` > -1 
            AND `trash` = 'false' 
            ORDER BY `datetime` DESC
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Add a download entry to contents table.
 * 
 * @param string $title      - Title of the download.
 * @param string $text       - Text (content) of the download.
 * @param string $path       - Path to the download.
 * @param string $filename   - Filename of the download.
 * @param string $visibility - 
 * 
 * @since 0.8.0
 */
function addDownload(string $title, 
    string $text, 
    string $path, 
    string $filename, 
    string $visibility)
{
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `text`, 
        `content_type`, 
        `path`, 
        `filename`, 
        `visibility`
        )
        VALUES (
            :title, 
            :text, 
            :content_type,
            :path, 
            :filename, 
            :visibility
        )
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $contentType = 'download';
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $contentType);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visibility', $visibility);
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update a download entry.
 * 
 * @param string $title
 * @param string $comment
 * @param string $path
 * @param string $filename
 * @param string $visible
 * 
 * @since 0.8.0
 */
function updateDownload(int $id, 
    string $title, 
    string $text, 
    string $path, 
    string $filename, 
    string $visible)
{
    $pdo = getPdoConnection();
    
    $sql = "
    UPDATE `contents` 
        SET `title` = :title, 
            `text` = :text, 
            `content_type` = :content_type,
            `path` = :path, 
            `filename` = :filename, 
            `visibility` = :visibility
            WHERE `content_type` = 'download'
                AND `id` = :id
    ";
    
    try {
        $content_type = 'download';
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visibility', $visible);
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
function updateDownloadsSettings(string $tagline, string $comment)
{
    $sql = '
    UPDATE `downloads_settings` 
        SET `tagline`= :tagline,
        `comment`= :comment 
        WHERE 1';
    
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
 * 
 * @since 0.8.0
 */
function loadLinksStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `uri`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility`
        FROM `contents` 
        WHERE `content_type` = 'link'
            AND `flag` = '' 
            ORDER BY `title` DESC
    ";

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
 * Get a link entry from table 'links' by id.
 * 
 * @param int $id - Id of a link entry.
 * @return array  - List of a link entry.
 * 
 * @since 0.8.0
 */
function getLinks(int $id)
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `tagline`, 
        `uri`, 
        `text`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `content_type` = 'link'
            AND `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_NUM);
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

    $sql = "
    SELECT links.title, 
        links.tagline, 
        links.uri, 
        links.comment, 
        UNIX_TIMESTAMP(links.created_at) AS datetime,
        links_settings.tagline as settings_tagline, 
        links_settings.comment as settings_comment
        FROM `links`, 
            `links_settings`
        WHERE `visibility` > -1 
            AND `trash` = 'false' 
            ORDER BY `datetime` DESC
    ";

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
 * @since 0.8.0
 */
function addLink(string $title, 
    string $tagline, 
    string $text, 
    string $uri, 
    string $visible)
{
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `tagline`, 
        `uri`, 
        `text`, 
        `content_type`, 
        `visibility`
        )
        VALUES (
            :title, 
            :tagline, 
            :uri, 
            :text, 
            :content_type,
            :visibility
        )";
    
    $pdo = getPdoConnection();
    
    try {
        $content_type = 'link';
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visible);
        
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
 * @since 0.8.0
 */
function updateLink(int $id, 
    string $title, 
    string $text, 
    string $uri, 
    string $visibility)
{
    $sql = "
    UPDATE `contents` 
        SET `title` = :title, 
        `text` = :text, 
        `uri` = :uri, 
        `visibility` = :visibility 
        WHERE `content_type` = 'link'
            AND `id` = :id
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visibility);
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
    $sql = "
    UPDATE `links_settings` 
        SET `tagline`= :tagline,
        `comment`= :comment 
        WHERE 1
    ";
    
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

    $sql = "
    SELECT `id`, 
        `title`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility`
        FROM `contents` 
        WHERE `content_type`= 'article'
            AND `flag` = '' 
            ORDER BY `created_at` DESC
    ";

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

    $sql = '
    SELECT `title`, 
        `content`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime 
        FROM `articles` 
        WHERE `id` = :id
    ';

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
 * Add a new article in 'articles' table.
 * 
 * @param string $title   - Title of an article.
 * @param string $content - Content of an article.
 * @param string $visible - Is an article visible or not.
 * 
 * @since 0.3.0
 */
function addArticle(string $title, string $content, string $visible)
{
    $contentType = 'article';
    
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `text`, 
        `content_type`,
        `visibility`
        ) 
        VALUES (
            :title, 
            :text, 
            :content_type,
            :visibility
        )
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $content);
        $stmt->bindParam(':content_type', $contentType);
        $stmt->bindParam(':visibility', $visible);
        
        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update a article in 'articles' table by id.
 * 
 * @param int $id            - Id of an article.
 * @param string $title      - Title of an article.
 * @param string $content    - Content of an article.
 * @param string $visibility - Is article visible or not.
 * 
 * @since 0.3.0
 */
function updateArticle(int $id, string $title, string $content, string $visibility)
{
    $pdo = getPdoConnection();
    
    $sql = "
    UPDATE `contents` 
        SET `title` = :title, 
        `text` = :text, 
        `visibility` = :visibility 
        WHERE `id` = :id
    ";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $content);
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
    $sql = '
    UPDATE `articles_settings` 
    SET `tagline`= :tagline,
        `comment`= :comment 
        WHERE 1
    ';
    
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
    $sql = "
        SELECT articles.id, 
        articles.title, 
        articles.content, 
        UNIX_TIMESTAMP(articles.created_at) AS datetime,
        articles_settings.tagline as tagline, 
        articles_settings.comment as comment
        FROM `articles`, `articles_settings`
        WHERE `visibility` > -1 
            AND `trash` = 'false' 
            ORDER BY `datetime` DESC
    ";

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
 * Get an article entry from 'articles' table by id.
 * 
 * @param int $id - Id from an article entry.
 * @return array  - Article list from an entry.
 * 
 * @since 0.4.0
 */
function getArticle(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `text`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `id` = :id 
            AND `flag` != 'trash'
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_NUM);
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

    $sql = "
    SELECT `id`, 
        `title`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility`
        FROM `contents` 
        WHERE `content_type` = 'page'
            AND `flag` = '' 
            ORDER BY `created_at` DESC
    ";

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
 * Get a page entry from table 'contents' by id.
 * 
 * @param int $id
 * @return array
 * 
 * @since 0.4.0
 */
function getPage(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `tagline`, 
        `text`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `content_type`= 'page'
            AND `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_NUM);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Add a page entry into `contents` table.
 * 
 * @param string $title      - Title of the page.
 * @param string $tagline    - Tagline of the page.
 * @param string $text       - Text of the page.
 * @param string $visibility - 
 * 
 * @since 0.8.0
 */
function addPage(string $title, string $tagline, string $text, string $visibility)
{
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `tagline`, 
        `text`, 
        `content_type`, 
        `visibility`
        )
        VALUES (
            :title, 
            :tagline, 
            :text, 
            :content_type,
            :visibility
        )";
    
    $pdo = getPdoConnection();
    
    try {
        $contentType = 'page';
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $contentType);
        $stmt->bindParam(':visibility', $visibility);
        
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
 * @param string $text
 * @param string $visibility
 * 
 * @since 0.8.0
 */
function updatePage(int $id, 
    string $title, 
    string $tagline, 
    string $text, 
    string $visibility)
{
    $pdo = getPdoConnection();

    $sql = "
    UPDATE `contents` 
        SET `title` = :title, 
            `tagline` = :tagline, 
            `text` = :text, 
            `visibility` = :visibility 
            WHERE `content_type` = 'page'
                AND `id` = :id
    ";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
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

    $sql = '
    SELECT `id`,
           `firstname`,
           `lastname`,
           `username`,
           `active`
           FROM `users` 
               ORDER BY `firstname` DESC';

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

    $sql = '
    SELECT `id`, 
        `firstname`, 
        `lastname` , 
        `email`, 
        `password`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `username`, 
        `active`
        FROM `users` 
        WHERE `id` = :id
    ';

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

    $sql = "
    SELECT `id`, 
        `title`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime
        FROM `$table` 
        WHERE `trash` = 'true' 
            ORDER BY `created_at` DESC
    ";

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
 * Get a list from 'settings' table.
 * 
 * @return array - List of settings entries.
 * 
 * @since 0.4.0
 */
function getGeneralSettings() : array
{
    $sql = "
    SELECT `title`, 
        `tagline`, 
        `theme`, 
        `darkmode`, 
        `blog_url`, 
        `lang_short`, 
        `footer`
        FROM `settings`
        WHERE 1";

    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update settings-table.
 * 
 * @param string $title
 * @param string $tagline
 * @param string $theme
 * @param string $blogUrl
 * @param string $language
 * @param string $footer
 */
function updateGeneralSettings(string $title, 
    string $tagline, 
    string $theme, 
    string $darkmode,
    string $blogUrl, 
    string $language, 
    string $footer)
{
    $sql = '
    UPDATE `settings` 
        SET `title`=:title,
            `tagline`=:tagline,
            `theme`=:theme,
            `darkmode`=:darkmode,
            `blog_url`=:blog_url,
            `lang_short`=:language,
            `footer`=:footer 
            WHERE 1
    ';
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':darkmode', $darkmode);
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

    // @todo: prüfen was das ist...
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

    $sql = "
    UPDATE `$table` 
        SET `trash`='true' 
        WHERE `id`= :id
    ";

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

    $sql = "
    SELECT `title` 
        FROM `$table` 
        WHERE `id` = :id
    ";

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

    $sql = "SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'article'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'download'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'link'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'page'
        UNION ALL
        SELECT COUNT(*) as result
            FROM `contents`
            WHERE `flag`= 'trash'";

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

    $sql = "
    SELECT `id`, 
        `title`, 
        UNIX_TIMESTAMP(`created_at`) AS datetime, 
        `visibility`
        FROM `$table` 
        WHERE `trash` = 'false' 
            ORDER BY `created_at` 
            DESC LIMIT $count
    ";

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

    $sql = '
    SELECT `username` 
        FROM `users` 
        WHERE `id` = :id
    ';

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