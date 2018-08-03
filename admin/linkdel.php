<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    $id = filter_input(INPUT_GET, 'id');
    $action = filter_input(INPUT_POST, 'action');

    // @todo Unsicher!!! Beheben!!!
    $list = isset($_POST['chk_select']) ? $_POST['chk_select'] : array();

    $uri = '';

    switch ( $action ) {
        case 'del' : deleteItemdsById($list, 'links');
            $uri .= 'trash';
            break;
        case 'del_all' : deleteAllTrashItems('links');
            $uri .= 'trash';
            break;
        default: setFlagTrashById($id, 'links');
            $uri .= 'links';
    }

    header ( "Location: index.php?uri=$uri" );

}