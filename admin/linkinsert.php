<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {

    $title   = filter_input(INPUT_POST, 'title');
    $tagline = filter_input(INPUT_POST, 'tagline');

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // @todo prüfen!!! uri überschneidet sich mit router=>uri
    $uri     = filter_input(INPUT_POST, 'uri');
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $comment = filter_input(INPUT_POST, 'comment');
    $visible = filter_input(INPUT_POST, 'visible');

    $pdo = getPdoConnection();

    $sql = "INSERT INTO `links` (`title`, `tagline`, `uri`, `comment`, `visible`) 
        VALUES (:title, :tagline,, :uri :comment, :visible)";

    if( DB_DRIVER == 'sqlite' ) {
        $datetime = strftime('%Y-%m-%d %H:%M', time());
        $trash = 'false';

        $sql = "INSERT INTO `links` (`title`, `tagline`, `uri`, `comment`, `created_at`, `visible`, `trash`)
        VALUES (:title, :tagline, :uri, :comment, :created_at, :visible, :trash)";
    }

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visible', $visible);

        if ( DB_DRIVER == 'sqlite' ) {
            $stmt->bindParam(':created_at', $datetime);
            $stmt->bindParam(':trash', $trash);
        }

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header('Location: index.php?uri=links');

}