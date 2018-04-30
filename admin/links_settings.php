<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */

if (is_logged_in ()) {

    $pdo = getPdoConnection();

    $tagline = filter_input(INPUT_POST, 'tagline');
    $comment = filter_input(INPUT_POST, 'comment');

    $sql = "UPDATE `links_settings` SET `tagline`= :tagline,`comment`= :comment WHERE 1";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':comment', $comment);

        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }

    header ( 'Location: index.php?uri=linksettings' );

}