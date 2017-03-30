<?php

  /* Konfigurationsdateien laden */
  include('../inc/base.inc.php');
  include('../inc/adminfunctions.inc.php');
  include('../inc/login.inc.php');

	/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
	if(is_logged_in())
	{
		$id = $_POST['id'];
		$title = $_POST['title'];
		$comment = $_POST['comment'];
		$path = $_POST['path'];
		$filename = $_POST['filename'];
		$visible = $_POST['visible'];
		
    include('../inc/database.inc.php');
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = "INSERT INTO downloads (title,comment,path,filename,visible) VALUES ('$title','$comment','$path','$filename',$visible)";
      $result = mysql_query($sql);
			header('Location: index.php?cmd=downloads');
		}
	}

?>