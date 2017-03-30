<?php
error_reporting(-1);
ini_set('display_errors', true);
/* Session initialisieren */
session_start();

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if($username && $password) {

    include '../inc/database.inc.php';
    $con = mysqli_connect($db['host'],$db['uid'],$db['pwd']);//var_dump($db,$username,$password);die;
    if($con) {    
        if(mysqli_select_db($con,$db['db'])) {
            $sql = "SELECT id FROM user WHERE (username = '$username') AND (password = '$password') AND (active = 'true')";
            $result = mysqli_query($con, $sql);//var_dump($sql);die;
        
            if($result && (@mysqli_num_rows($result) > 0)) {
                $row = mysqli_fetch_row($result);
                $_SESSION['authenticated'] = true;
                $_SESSION['user_id'] = $row[0];
                $_SESSION['username'] = $username;
            } else {
                $_SESSION['authenticated'] = false;
            }
        }
    }
}

header('Location: index.php');


