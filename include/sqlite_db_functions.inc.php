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

function updateMainpage($title, $text)
{
    $pdo = getPdoConnection();
    
    $sql="
    UPDATE `contents`
        SET `title` = :title,
            `text` = :text
            WHERE `content_type` = 'mainpage'
                AND `flag` = 'infobox'
    ";
    
    try {
        $stmt=$pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

function getInfobox()
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `title`, 
        `text`
        FROM `contents`
        WHERE `content_type` = 'mainpage'
            AND `flag` = 'infobox'
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
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
        WHERE `id` = :id
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
 * Update settings-table.
 * 
 * @param string $title
 * @param string $tagline
 * @param string $theme
 * @param string $blogUrl
 * @param string $language
 * @param string $footer
 * 
 * @since 0.8.0
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
 * Delete a content entry from contents-table by id.
 * 
 * @param int $id - Id of an item. 
 * 
 * @since 0.8.0
 */
function deleteItemById(int $id)
{
    $pdo = getPdoConnection();

    $sql = "
    DELETE FROM `contents` 
    WHERE `id` = :id
        AND `flag`= 'trash'
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
 *
 * @param string $table
 */
function deleteAllTrashItems(string $table)
{
    $pdo = getPdoConnection();

    $sql = "
    DELETE FROM `:table` 
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
 * @param string $flag
 * 
 * @since 0.8.0
 */
function setContentsFlagById(int $id, string $flag)
{
    $pdo = getPdoConnection();

    $sql = "
    UPDATE `contents` 
        SET `flag`=:flag 
        WHERE `id`= :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':flag', $flag);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Get a title of a content by id.
 *
 * @param int $id - Id of a content title.
 *
 * @return string
 */
function getContentsTitleById(int $id)
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `title` 
        FROM `contents` 
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
 *
 * @param string $type
 * @return int
 */
function countContentType(string $type): int
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT COUNT(`id`)
        FROM `contents`
        WHERE `content_type` = '$type'
            AND `flag` != 'trash'
            AND `visibility` = 'true'
    ";
    
    foreach ($pdo->query($sql) as $row) {
        $id = (int) $row[0];
    }
    
    return $id;
}

/**
 * Count all Entries for navigation information
 *
 * @return array
 * 
 * @since 0.8.0
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
 * @deprecated
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
 * Get username from users-table by id
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