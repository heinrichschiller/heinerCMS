<?php
error_reporting ( - 1 );
ini_set ( 'display_errors', true );

include __DIR__ . '/functions.inc.php';
include __DIR__ . '/installer/Db_Installer.php';
include __DIR__ . '/../source/library/db_adapter/Db_Adapter.php';
include __DIR__ . '/../source/controllers/user/UserController.php';
include __DIR__ . '/../source/models/user/UserModel.php';

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

$installer->createDatabase($dbase);

$installer->selectDatabase($dbase);

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

$db = getPdoDB2();

$userModel = new UserModel();
$user = new UserController($db, $userModel);

$userModel->fetchAll($user_data);
$user->create();

$source_path = __DIR__ .'/';
$destiny_path = __DIR__ .'/../source/configs/';
$file = 'config.ini';

if(file_exists($file)) {
    copy($source_path.$file, $destiny_path.$file);
} else {
    echo 'Error!';
}

$out  = '<p>Die Installation lief erfolgreich durch!</p>';
$out .= '<p>Sie k&ouml;nnen sich nun einloggen.</p>';
$out .= '<p><a href="'.$_SERVER['PHP_SELF'].'/../../admin/index.php">Zum Login</a></p>';

echo $out;