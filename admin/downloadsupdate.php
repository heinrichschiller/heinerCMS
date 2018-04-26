<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */
if (is_logged_in ()) {

    $id       = filter_input(INPUT_POST, 'id');
    $title    = filter_input(INPUT_POST, 'title');
    $comment  = filter_input(INPUT_POST, 'comment');
    $path     = filter_input(INPUT_POST,'path');
    $filename = filter_input(INPUT_POST,'filename');
    $visible  = filter_input(INPUT_POST,'visible');

    $pdo = getPdoConnection();

    $sql = "UPDATE `downloads` SET `title` = :title, `comment` = :comment, `path` = :path, `filename` = :filename, `visible` = :visible 
        WHERE `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':path', $path);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':visible', $visible);
        $stmt->bindParam(':id', $id);

        $stmt->execute($input_parameters);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

    header('Location: index.php?uri=downloads');

}
