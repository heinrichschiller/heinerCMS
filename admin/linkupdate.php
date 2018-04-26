<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {

    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // @todo prüfen!!! uri überschneidet sich mit router=>uri
    $uri     = filter_input(INPUT_POST, 'uri');
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $comment = filter_input(INPUT_POST, 'comment');
    $visible = filter_input(INPUT_POST, 'visible');

    $pdo = getPdoConnection();

    $sql = "UPDATE `links` SET `title` = :title, `comment` = :comment, `uri` = :uri, `visible` = :visible WHERE `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visible', $visible);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    } catch(PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header('Location: index.php?uri=links');

}