<?php
error_reporting ( - 1 );
ini_set ( 'display_errors', true );

include __DIR__ . '/functions.inc.php';
include __DIR__ . '/source/Library/db_adapter/Db_Adapter.php';
include __DIR__ . '/source/Library/installer/Db_Installer.php';
include __DIR__ . '/source/Library/user/User.php';

// init
$host = filter_input(INPUT_POST ,'hostname');
$user = filter_input(INPUT_POST, 'username');
$psswd = filter_input(INPUT_POST, 'password');
$dbase = filter_input(INPUT_POST, 'database');

$firstname = filter_input(INPUT_POST, 'firstname');
$lastname  = filter_input(INPUT_POST, 'lastname');
$email     = filter_input(INPUT_POST, 'email');
$username  = filter_input(INPUT_POST, 'username');
$user_psswd_1 = filter_input(INPUT_POST, 'passwd1');
$user_psswd_2 = filter_input(INPUT_POST, 'passwd2');

// Create a config.ini file at first
// We need this for our database connection to create a database
// and an user. Later we copied config.ini in to the /inc-directory
// and use this for our application.
if(!file_exists('config.ini')) {
	createConfig($host,$user,$psswd,$dbase);
}

if (file_exists('config.ini')) {
	$ini_array = parse_ini_file('config.ini');
}

$db_adapter = new Db_Adapter($ini_array);
$db_adapter->init();

$db = $db_adapter->getAdapter();

$installer = new Db_Installer($db);

$installer->createDB($dbase);

$installer->selectDB($dbase);

$installer->createTableArticles();

$installer->createTableDownloads();

$installer->createTableLinks();

$installer->createTableNews();

$installer->createTableUsers();

$user_data = [
	'firstname' => $firstname,
	'lastname' => $lastname,
	'email' => $email,
	'username' => $username,
	'password1' => $user_psswd_1,
	'password2' => $user_psswd_2
];

$user = new User($db, $user_data);
$user->create();



