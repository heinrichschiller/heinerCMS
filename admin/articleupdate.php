<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {

    $id         = filter_input(INPUT_POST, 'id');
    $title      = filter_input(INPUT_POST, 'title');
    $content    = filter_input(INPUT_POST, 'content');
    $visibility = filter_input(INPUT_POST, 'visible');

    updateArticleEntry($id, $title, $content, $visibility);

    header('Location: index.php?uri=articles');
}