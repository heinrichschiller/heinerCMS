<?php

session_start ();

/* Wert setzen */
session_unset();

/* Session beenden */
session_destroy ();

/* Umleitung */
header ( 'Location: ../index.php?uri=admin' );