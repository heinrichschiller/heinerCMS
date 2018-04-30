<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */

if (is_logged_in ()) {

    $pdo = getPdoConnection();

    $title   = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');
    $visible = filter_input(INPUT_POST, 'visible');

    $sql = "INSERT INTO `articles` (`title`, `content`, `visible`) VALUES (:title, :content, :visible)";

    if(DB_DRIVER === 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';

        $sql = "INSERT INTO `articles` (`title`, `content`, `created_at`, `visible`, `trash`) 
            VALUES (:title, :content, :created_at, :visible, :trash)";
    }

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':visible', $visible);

        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }

        $stmt->execute($input_parameters);
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
}

    header ( 'Location: index.php?uri=articles' );
}

