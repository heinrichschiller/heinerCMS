<?php

session_start();

include __DIR__ . '/../config/cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in ()) {

    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');
    $message = filter_input(INPUT_POST, 'message');
    $visible = filter_input(INPUT_POST, 'visible');

    updateNews($id, $title, $message, $visible);

    header ('Location: index.php?uri=news');
}