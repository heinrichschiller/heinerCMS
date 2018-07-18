<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {

    $id       = filter_input(INPUT_POST, 'id');
    $title    = filter_input(INPUT_POST, 'title');
    $comment  = filter_input(INPUT_POST, 'comment');
    $path     = filter_input(INPUT_POST,'path');
    $filename = filter_input(INPUT_POST,'filename');
    $visible  = filter_input(INPUT_POST,'visible');

    updateDownload($id, $title, $comment, $path, $filename, $visible);

    header('Location: index.php?uri=downloads');

}
