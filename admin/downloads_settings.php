<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in ()) {
    $tagline = filter_input(INPUT_POST, 'tagline');
    $text = filter_input(INPUT_POST, 'text');

    updateDownloadsSettings($tagline, $text);
    
    header ( 'Location: index.php?uri=downloadssettings' );

}