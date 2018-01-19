<?php

include __DIR__ . '/../inc/general_functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    $id = filter_input(INPUT_POST, 'id');
    $action = filter_input(INPUT_POST, 'action');
    
    $uri = '';

    // @todo Unsicher!!! Beheben!!!
    $list = isset($_POST['chk_select']) ? $_POST['chk_select'] : array();
    
    switch ( $action ) {
        case 'del' : deleteItemdsById($list, 'links');
            $uri = 'trash';
            break;
        case 'del_all' : deleteAllTrashItems('links');
            $uri = 'trash';
            break;
        default: setFlagTrashById($id, 'links');
            $uri = 'links';
    }
    
    header ( "Location: index.php?uri=$uri" );
}
