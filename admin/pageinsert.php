<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    $title   = filter_input(INPUT_POST, 'title');
    $tagline = filter_input(INPUT_POST, 'tagline');
    $content = filter_input(INPUT_POST, 'content');
    $visible = filter_input(INPUT_POST, 'visible');

    addPage($title, $tagline, $content, $visible);
    
    header ( 'Location: index.php?uri=pages' );
}

