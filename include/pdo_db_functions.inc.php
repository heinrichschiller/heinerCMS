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
        echo $ex->getMessage();
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

function loadNewsStatement()
{
    $pdo = getPdoConnection();
    
    $datetime = 'UNIX_TIMESTAMP(`created_at`) AS datetime';
    
    if (DB_DRIVER == 'sqlite') {
        $datetime = 'date(`created_at`) AS datetime';
    }
    
    $sql = "SELECT `id`, `title`, $datetime, `visible`"
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