<?php

session_start();

include __DIR__ . '/../config/cms-config.php';
include __DIR__ . '/../config/db-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in()) {

    $title    = filter_input(INPUT_POST, 'title');
    $theme    = filter_input(INPUT_POST, 'theme');
    $tagline  = filter_input(INPUT_POST, 'tagline');
    $blogUrl  = filter_input(INPUT_POST, 'blogUrl');
    $language = filter_input(INPUT_POST, 'language');
    $footer   = filter_input(INPUT_POST, 'footer');

    updateGeneralSettings($title, $tagline, $theme, $blogUrl, $language, $footer);

    header ( "Location: index.php?uri=general" );
}
