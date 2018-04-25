<?php

/**
 * Database connection for heinerCMS that use PDO-Connection.
 * 
 * @param string $driver Driver can be mysql or sqlite.
 * 
 * @return PDO
 */
function getPdoConnection()
{
    try {
        
        //$pdo = new PDO( DB_DRIVER . ':host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD );
        $pdo = new PDO (DB_DRIVER . ':' . DB_NAME);
        
        return $pdo;
        
    } catch (PDOException $ex) {
        echo $ex->getMessage() . DB_NAME;
        exit();
    }
    
}

/**
 *
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
 * @param string $sql
 * @param array $params
 */
function pdo_query(string $sql, array $params)
{
    $pdo = getPdoDB();
}

function datetimeFormater() : string
{
    $datetime = 'UNIX_TIMESTAMP(`created_at`) AS datetime';
    
    if (DB_DRIVER == 'sqlite') {
        $datetime = "strftime('%s', `created_at`) AS datetime";
    }
    
    return $datetime;
}

function loadNewsStatement()
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

function loadNewsEditStatement(int $id)
{
    $pdo = getPdoConnection();
    
    $sql = 'SELECT `id`, `title`, `message`, ' . datetimeFormater() . ', `visible`'
        . " FROM `news` WHERE `id` = :id";
    
    $input_parameters = [
        ':id' => $id
    ];
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

function loadDownloadsStatement()
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

function loadDownloadsSettingsStatement()
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

function loadLinksStatement()
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

function loadArticlesStatement()
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

function loadPagesStatement()
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
    
    $sql = 'SELECT `id`, `title`, ' . datetimeFormater() . " FROM `$table` WHERE `trash` = 'true' ORDER BY `created_at` DESC";
        
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}