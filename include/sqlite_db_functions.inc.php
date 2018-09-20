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
        $pdo = new PDO(DB_DRIVER . ':' . DB_NAME);
        
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
 */
function loadDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        strftime('%s', `created_at`) AS datetime, 
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
        strftime('%s', `created_at`) AS datetime, 
        `visibility`
        FROM `contents` 
        WHERE `content_type` = 'download'
            AND `id`= :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 *
 * @return PDOStatement
 */
function getDownloadSettings() : array
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `tagline`,
        `text`
        FROM `contents_settings`
        WHERE `content_type` = 'download';
    ";
    
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
 * 
 * @return PDOStatement
 */
function loadDownloadsSettingsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `tagline`, 
        `text` 
        FROM `contents_settings` 
        WHERE `content_type` = 'download';
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
 * @return PDOStatement
 * 
 * @since 0.8.0
 */
function loadPublicDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `contents`.`title`, 
        `contents`.`text`, 
        `contents`.`path`, 
        `contents`.`filename`, 
        strftime('%s', contents.created_at) AS datetime,
        `contents_settings`.`tagline` as downloads_tagline, 
        `contents_settings`.`text` as downloads_text 
        FROM `contents`, 
            `contents_settings`
            WHERE `contents`.`content_type` = 'download' 
                AND `contents_settings`.`content_type` = 'download' 
                AND `visibility` = 'true' 
                AND `flag` != 'trash' 
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
 * Add a download.
 * 
 * @param string $title         - Title of a download.
 * @param string $text          - Text of a download.
 * @param string $path          - Path of a download.
 * @param string $filename      - Filename of a download.
 * @param string $visibility    - Is a download visible or not.
 * 
 * @since 0.8.0
 */
function addDownload(string $title, 
    string $text, 
    string $path, 
    string $filename, 
    string $visibility
    )
{
    $flag = '';
    $content_type = 'download';
    
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `text`, 
        `content_type`, 
        `path`, 
        `filename`, 
        `visibility`,
        `flag`
        )
        VALUES (
            :title, 
            :text, 
            :content_type,
            :path, 
            :filename, 
            :visibility,
            :flag
        )
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);
        
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
 * @param string $text
 * @param string $path
 * @param string $filename
 * @param string $visibility
 * 
 * @since 0.3.0
 */
function updateDownload(int $id, 
    string $title, 
    string $text, 
    string $path, 
    string $filename, 
    string $visibility)
{
    $pdo = getPdoConnection();
    
    $sql = "
    UPDATE `contents` 
        SET `title` = :title, 
            `text` = :text, 
            `path` = :path, 
            `filename` = :filename, 
            `visibility` = :visibility
            WHERE `content_type` = 'download'
                AND `id` = :id
    ";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
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
 * 
 * @since 0.8.0
 */
function updateDownloadsSettings(string $tagline, string $text)
{
    $sql = "
    UPDATE `contents_settings` 
        SET `tagline`= :tagline,
        `text`= :text 
        WHERE `content_type`= 'download'
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        
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
        strftime('%s', `created_at`) AS datetime, 
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
 * Get a link entry from table 'contents' by id.
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
        strftime('%s', `created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `content_type` = 'link'
            AND `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

}

function getLinksSettings() : array
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `tagline`,
        `text`
        FROM `contents_settings`
        WHERE `content_type` = 'link'
    ";
    
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
 * 
 * @return PDOStatement
 * 
 * @since 0.8.0
 */
function loadPublicLinksStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT contents.title, 
        contents.tagline, 
        contents.uri, 
        contents.text, 
        strftime('%s', contents.created_at) AS datetime,
        contents_settings.tagline as settings_tagline, 
        contents_settings.text as settings_comment
        FROM `contents`, 
            `contents_settings`
        WHERE `contents`.`content_type` = 'link'
            AND `contents_settings`.`content_type` = 'link'
            AND `visibility` = 'true' 
            AND `flag` != 'trash' 
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
 * @param string $text
 * @param string $uri
 * @param string $visibility
 * 
 * @since 0.8.0
 */
function addLink(string $title, 
    string $tagline, 
    string $text, 
    string $uri, 
    string $visibility)
{
    $content_type = 'link';
    $flag = '';
        
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `tagline`, 
        `uri`, 
        `text`, 
        `content_type`, 
        `visibility`,
        `flag`
        )
        VALUES (
            :title, 
            :tagline, 
            :uri, 
            :text, 
            :content_type,
            :visibility,
            :flag
        )";
    
    $pdo = getPdoConnection();
    
    try {        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);
        
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
 * @param string $text
 * @param string $uri
 * @param string $visibility
 * 
 * @since 0.3.0
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
        strftime('%s', `created_at`) AS datetime, 
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
 * @return array
 * 
 * @since 0.8.0
 */
function getArticleDetailed(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `title`, 
        `text`, 
        strftime('%s', `created_at`) AS datetime 
        FROM `contents` 
        WHERE `content_type` = 'article'
            AND `visibility` = 'true'
            AND `flag` != 'trash' 
            AND `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Add a new article in 'articles' table.
 * 
 * @param string $title      - Title of an article.
 * @param string $text       - Text of an article.
 * @param string $visibility - Is an article visible or not.
 * @param string $trash      - Set trash flag, is an article trash or not.
 * 
 * @since 0.8.0
 */
function addArticle(string $title, string $text, string $visibility)
{
    $contentType = 'article';
    $flag = '';
    
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `text`, 
        `content_type`,
        `visibility`,
        `flag`
        ) 
        VALUES (
            :title, 
            :text, 
            :content_type,
            :visibility,
            :flag
        )
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $contentType);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);
        
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
 * @param string $text       - Text of an article.
 * @param string $visibility - Is article visible or not.
 * 
 * @since 0.8.0
 */
function updateArticle(int $id, string $title, string $text, string $visibility)
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
        $stmt->bindParam(':text', $text);
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
    $sql = "
    UPDATE `articles_settings` 
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
 * 
 * @since 0.8.0
 */
function loadPublicArticlesStatement() : PDOStatement
{
    $sql = "
    SELECT `contents`.`id`, 
        `contents`.`title`, 
        `contents`.`text`, 
        strftime('%s', contents.created_at) AS datetime,
        `contents_settings`.`tagline` as tagline, 
        `contents_settings`.`text` as text
        FROM `contents`, 
            `contents_settings`
            WHERE `contents`.`content_type` = 'article'
                AND `contents_settings`.`content_type` = 'article'
                AND `visibility` = 'true' 
                AND `flag` != 'trash' 
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
 * @since 0.8.0
 */
function getArticle(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `text`, 
        strftime('%s', `created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `id` = :id 
            AND `flag` != 'trash'
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

function getArticleSettings() : array
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `tagline`,
        `text`
        FROM `contents_settings`
        WHERE `content_type` = 'article'
    ";
    
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
 * 
 * @return PDOStatement
 */
function loadPagesStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        strftime('%s', `created_at`) AS datetime, 
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
 * Get a page entry from table 'pages' by id.
 * 
 * @param int $id
 * @return array
 * 
 * @since 0.8.0
 */
function getPage(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `tagline`, 
        `text`, 
        strftime('%s', `created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `content_type`= 'page'
            AND `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
 * @param string $visibility
 * 
 * @since 0.3.0
 */
function addPage(string $title, 
    string $tagline, 
    string $text, 
    string $visibility)
{
    $content_type = 'page';
    $flag = '';
        
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `tagline`, 
        `text`, 
        `content_type`, 
        `visibility`,
        `flag`
        )
        VALUES (
            :title, 
            :tagline, 
            :text, 
            :content_type,
            :visibility,
            :flag
        )
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);
        
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
            ORDER BY `firstname` DESC
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
 * Get an user entry from 'users' table by id.
 * 
 * @param int $id - Id from an user entry.
 * @return array  - User list from an entry.
 * 
 * @since 0.8.0
 */
function getUser(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `firstname`, 
        `lastname`,
        `email`, 
        `password`, 
        strftime('%s', `created_at`) AS datetime, 
        `username`, 
        `active`
        FROM `users`
        WHERE `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
function getTrashEntries()
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        strftime('%s', `created_at`) AS datetime, 
        `content_type`
        FROM `contents` 
        WHERE `flag` = 'trash' 
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
        WHERE 1
    ";
    
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
 * 
 * @param string $title
 * @param string $tagline
 * @param string $theme
 * @param string $blogUrl
 * @param string $language
 * @param string $footer
 * 
 * @since 0.5.0
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

    $sql = "
    DELETE 
        FROM `$table` 
        WHERE `id` = '$items[0]'
    ";
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

    $sql = "
    DELETE 
        FROM `:table` 
        WHERE `trash` = 'true'
    ";

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

    $sql = "
    SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'article' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'download' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'link' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'page' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(*) as result
            FROM `contents`
            WHERE `flag` = 'trash'
    ";

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
            ORDER BY `created_at` DESC LIMIT $count
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