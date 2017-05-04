<?php
error_reporting(-1);
ini_set('display_errors', true);

session_start();

$email = filter_input(INPUT_POST, 'email');
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$login_password = filter_input(INPUT_POST, 'password');

$config = __DIR__ . '/../source/configs/config.ini';

if (file_exists($config)) {
	$ini_array = parse_ini_file($config);
	
	$host = $ini_array['host'];
	$user = $ini_array['user'];
	$password = $ini_array['password'];
	$database = $ini_array['database'];
}

try {
	$pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

	$sql = "SELECT `id`,`email`,`username`,`password` FROM `users` WHERE email = :email";

	$stmt = $pdo->prepare($sql);
	$result = $stmt->execute(array('email' => $email));
	$user = $stmt->fetch();

} catch (PDOException $ex) {
	echo $ex->getMessage();
}

if ($user !== false && password_verify($login_password, $user['password'])) {
	$_SESSION['authenticated'] = true;
	$_SESSION['user_id'] = $user['id'];
	$_SESSION['username'] = $user['username'];

	header('Location: index.php?uri=admin');
} else {
	$errorMessage = "E-Mail oder Passwort war ungültig<br>";
	echo $errorMessage;
}




