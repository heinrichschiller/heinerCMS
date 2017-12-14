<?php

$filename = __DIR__ . '/../source/configs/config.ini';

if (file_exists($filename)) {
    $ini_array = parse_ini_file($filename);
} else {
    echo 'File .config.ini not found.';
    exit();
}

$title = filter_input(INPUT_POST, 'title');
$theme = filter_input(INPUT_POST, 'theme');

$host = $ini_array['host'];
$user = $ini_array['user'];
$password = $ini_array['password'];
$database = $ini_array['database'];

$fp = fopen($filename, 'w');

fwrite($fp, "[Application]\n");
fwrite($fp, "title = $title\n");
fwrite($fp, "theme = $theme\n");
fwrite($fp, "version = 0.0.1");
fwrite($fp, "\n");
fwrite($fp, "[Database]\n");
fwrite($fp, "host = \n");
fwrite($fp, "user = $user\n");
fwrite($fp, "password = $password\n");
fwrite($fp, "database = $database\n");

fclose($fp);

header ( "Location: index.php?uri=general" );