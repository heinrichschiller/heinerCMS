<?php

session_start();

include __DIR__ . '/../configs/cms-config.php';
include __DIR__ . '/../configs/db-config.php';

include __DIR__ . '/../include/' . DB_DRIVER . '_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {

    $id     = filter_input(INPUT_POST, 'id');
    $action = filter_input(INPUT_POST, 'action');

    $pdo = getPdoConnection();

    $sql = 'DELETE FROM `users` WHERE id = :id';

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header ( "Location: index.php?uri=user" );
}