<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    $title   = filter_input(INPUT_POST, 'title');
    $tagline = filter_input(INPUT_POST, 'tagline');

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // @todo prüfen!!! uri überschneidet sich mit router=>uri
    $uri     = filter_input(INPUT_POST, 'uri');
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $comment = filter_input(INPUT_POST, 'comment');
    $visible = filter_input(INPUT_POST, 'visible');

    insertLinksEntry($title, $tagline, $comment, $uri, $visible);

    header('Location: index.php?uri=links');

}