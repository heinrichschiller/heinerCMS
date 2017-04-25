<?php
error_reporting(-1);
ini_set('display_errors', true);
include('../inc/database.inc.php');
  
$user = 'heinrich';
$pass = 'geheim';
  
$con = mysqli_connect($db['host'],$db['uid'],$db['pwd']);
if($con) {
    if(mysqli_select_db($con,$db['db'])) {

      $sql = "INSERT INTO user (username,password,email,active) VALUES ('$user','$pass','','true')";
      $result = mysqli_query($con,$sql);

      if($result) {
        echo "Admin wurde mit folgenden Daten erzeugt:<br><b>Benutzer:</b> $user<br><b>Passwort:</b> $pass";
      } else {
        echo 'Admin wurde nicht erzeugt!!!';
      }
    }
  }


