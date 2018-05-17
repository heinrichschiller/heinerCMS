<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {
    $title    = filter_input(INPUT_POST, 'title');
    $comment  = filter_input(INPUT_POST, 'comment');
    $path     = filter_input(INPUT_POST,'path');
    $filename = filter_input(INPUT_POST,'filename');
    $visible  = filter_input(INPUT_POST,'visible');

    $sql = "INSERT INTO `downloads` (`title`, `comment`, `path`, `filename`, `visibility`)
        VALUES (:title, :comment, :path, :filename, :visibility)";

    if ( DB_DRIVER == 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';

        $sql = "INSERT INTO `downloads` (`title`, `comment`, `path`, `filename`, `created_at`, `visibility`, `trash`)
            VALUES (:title, :comment, :path, :filename, :created_at, :visibility, :trash)";
    }

    $pdo = getPdoConnection();

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visibility', $visible);

        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header('Location: index.php?uri=downloads');
}
