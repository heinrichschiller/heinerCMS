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
		$uri = $_POST['uri'];
		$visible = $_POST['visible'];
		
    include('../inc/database.inc.php');
    $connection = mysql_connect($db['host'],$db['uid'],$db['pwd']);
    if($connection)
    {
      mysql_select_db($db['db']);
      $sql = "UPDATE links SET title = '$title', comment = '$comment', uri = '$uri', visible = $visible WHERE id = $id";
      $result = mysql_query($sql);
			header('Location: index.php?cmd=links');
		}
	}

?>