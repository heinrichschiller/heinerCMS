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
