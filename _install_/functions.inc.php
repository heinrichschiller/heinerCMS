<?php

function loadTemplate($template) {
	$file = __DIR__ . '/templates/'. $template . '.tpl.php';

	if (file_exists($file)) {
		return file_get_contents($file);
	}
	
	return false;
}

function createConfig($host,$user,$psswd,$dbase) {
	$path = '/../inc/';
	$filename = 'config.ini';

	$fp = fopen($filename, 'w');
	fwrite($fp, "[database]\n");
	fwrite($fp, "host = $host\n");
	fwrite($fp, "user = $user\n");
	fwrite($fp, "password = $psswd\n");
	fwrite($fp, "database = $dbase\n");
	fclose($fp);
}

/**
 * Database adapter for MySQL
 *
 * @return PDO
 */
function getPdoDB2()
{
    $config = __DIR__ . '/config.ini';

    if (file_exists($config)) {
        $ini_array = parse_ini_file($config);

        $host = $ini_array['host'];
        $user = $ini_array['user'];
        $password = $ini_array['password'];
        $database = $ini_array['database'];
    }
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        
        return $pdo;
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
}