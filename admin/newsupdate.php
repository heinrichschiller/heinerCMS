<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in ()) {

    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');
    $message = filter_input(INPUT_POST, 'message');
    $visible = filter_input(INPUT_POST, 'visible');

    $pdo = getPdoConnection();

    $sql = "UPDATE `news` SET `title` = :title, `message` = :message, `visibility` = :visibility WHERE `id` = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':visibility', $visible);
        $stmt->bindParam(':id', $id);

        $stmt->execute($inpuit_parameters);

    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
	}

    header ('Location: index.php?uri=news');
}