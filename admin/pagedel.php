<?php

session_start();

include __DIR__ . '/../config/cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {
    $id     = filter_input(INPUT_POST, 'id');
    $action = filter_input(INPUT_POST, 'action');
    $uri    = '';

    // @todo Unsicher!!! Beheben!!!
    $list = isset($_POST['chk_select']) ? $_POST['chk_select'] : array();

    switch ( $action ) {
        case 'del' : deleteItemsById($list, 'sites');
            $uri = 'trash';
            break;
        case 'del_all' : deleteAllTrashItems('sites');
            $uri = 'trash';
            break;
        default: setFlagTrashById($id, 'sites');
            $uri = 'pages';
    }

    header ( "Location: index.php?uri=$uri" );
}