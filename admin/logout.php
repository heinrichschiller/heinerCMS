<?php

// @todo: prepare for delete, because it is obsolete
session_start ();

/* Wert setzen */
$_SESSION ['authenticated'] = false;
$_SESSION ['username'] = '';
$_SESSION ['user_id'] = '';

/* Session beenden */
session_destroy ();

/* Umleitung */
header ( 'Location: index.php' );

