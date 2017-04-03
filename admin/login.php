<?php

// WARNING!!! THIS LOGIN-SCRIPT IS NOT SECURE!!!!

error_reporting(-1);
ini_set('display_errors', true);

session_start();

include __DIR__ . '/../inc/functions.inc.php';

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if($username && $password) {

    $con = getDB();

    if($con) {    
        $sql = "SELECT id FROM user WHERE (username = '$username') AND (password = '$password') AND (active = 'true')";
        $result = mysqli_query($con, $sql);
        
        if($result && (@mysqli_num_rows($result) > 0)) {
            $row = mysqli_fetch_row($result);
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $row[0];
            $_SESSION['username'] = $username;
        } else {
            $_SESSION['authenticated'] = false;
        }
        mysqli_close( $con );
    }
}

header('Location: index.php');


