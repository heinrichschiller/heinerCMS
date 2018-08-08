<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in()) {

    $title    = filter_input(INPUT_POST, 'title');
    $theme    = filter_input(INPUT_POST, 'theme');
    $darkmode = filter_input(INPUT_POST, 'darkmode');
    $tagline  = filter_input(INPUT_POST, 'tagline');
    $blogUrl  = filter_input(INPUT_POST, 'blogUrl');
    $language = filter_input(INPUT_POST, 'language');
    $footer   = filter_input(INPUT_POST, 'footer');
    
    if(!isset($darkmode)) {
        $darkmode = '';
    }
    
    updateGeneralSettings($title, $tagline, $theme, $darkmode, $blogUrl, $language, $footer);

    header ( "Location: index.php?uri=general" );
}
