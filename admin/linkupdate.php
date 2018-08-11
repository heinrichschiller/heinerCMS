<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {

    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // @todo prüfen!!! uri überschneidet sich mit router=>uri
    $uri     = filter_input(INPUT_POST, 'uri');
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $comment = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');

    updateLink($id, $title, $comment, $uri, $visibility);

    header('Location: index.php?uri=links');

}