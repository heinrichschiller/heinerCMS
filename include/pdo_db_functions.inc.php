<?php

/**
 * Database adapter for MySQL
 *
 * @return PDO
 */
function getPdoDB()
{
    try {
        
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        
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
    $pdo = getPdoDB();
    
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