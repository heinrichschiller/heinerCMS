<?php

/**
 * Database adapter for MySQL
 *
 * @return PDO
 */
function getPdoDB()
{
    $config = __DIR__ . '/../source/configs/config.ini';
    
    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);
        
        $type = $ini_array['type'];
        $host = $ini_array['host'];
        $user = $ini_array['user'];
        $password = $ini_array['password'];
        $database = $ini_array['database'];
    }
    
    try {
        
        if ($type == 'mysql') {
            $pdo = new PDO("$type:host=$host;dbname=$database", $user, $password);
        } else if($type == 'sqlite') {
            die('ist nocht nicht implementiert!');
        }
        
        
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

/**
 *
 * @param string $template
 * @return string
 */
function loadTemplate(string $template): string
{
    $file = __DIR__ . '/../templates/' . $_SESSION['theme'] . '/' . $template . '.tpl.php';
    $error = __DIR__ . '/../templates/' . $_SESSION['theme'] . '/error_template.tpl.php';
    
    if (file_exists($file)) {
        return file_get_contents($file);
    }
    
    return file_get_contents($error);
}