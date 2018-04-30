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
            $pdo = new PDO (DB_DRIVER . ':' . DB_NAME);
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
 * @deprecated
 * @param string $sql
 * @param array $params
 * @return array
 */
function pdo_select(string $sql, array $params) : array
{
    $pdo = getPdoConnection();

    try {
        $stmt = $pdo->prepare($sql);

        if (!empty($params)) {
            $stmt->execute( [$params[0] ]);
        } else {
            $stmt->execute();
        }

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    return $stmt->fetch();
}

/**
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

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() . ', `visible`'
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

    $sql = 'SELECT `id`, `title`, `message`, ' . datetimeFormater() . ', `visible`'
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
        WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() . ', `path`, `filename`, `visible`'
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

    $sql = 'SELECT `id`, `title`, `comment`, ' . datetimeFormater() . ', `path`, `filename`, `visible`'
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
        WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

/**
 * 
 * @return PDOStatement
 */
function loadLinksStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`, `uri`,' . datetimeFormater() . ', `visible`'
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

    $sql = "SELECT `id`, `title`, `tagline`, `uri`, `comment`, `visible` FROM `links` WHERE `id` = :id";

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
        WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

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
function loadArticlesStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() .', `visible`'
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
        WHERE `visible` > -1 AND `trash` = 'false' ORDER BY `datetime` DESC";

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

    $sql = 'SELECT `id`, `title`, `content`, ' . datetimeFormater() . ', `visible` FROM `articles` WHERE `id` = :id';

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

    $sql = 'SELECT `id`, `title`,' . datetimeFormater() . ', `visible`'
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
    
    $sql = 'SELECT `id`, `title`, UNIX_TIMESTAMP(`created_at`) AS datetime, `visible`'
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