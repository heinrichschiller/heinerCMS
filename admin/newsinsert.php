<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in()) {
    $title   = filter_input(INPUT_POST, 'title');
    $message = filter_input(INPUT_POST, 'message');
    $visible = filter_input(INPUT_POST, 'visible');

    $sql = "INSERT INTO `news` (`title`, `message`, `visible`)
        VALUES (:title, :message, :visible)";

    if (DB_DRIVER == 'sqlite') {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';

        $sql = "INSERT INTO `news` (`title`, `message`, `created_at`, `visible`, `trash`)
            VALUES (:title, :message, :created_at, :visible, :trash)";
    }

    $pdo = getPdoConnection();

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':visible', $visible);

        if (DB_DRIVER == 'sqlite') {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header('Location: index.php?uri=news');
}
