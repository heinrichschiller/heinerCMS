<?php

session_start();

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';

if (is_logged_in()) {

    $title    = filter_input(INPUT_POST, 'title');
    $theme    = filter_input(INPUT_POST, 'theme');
    $tagline  = filter_input(INPUT_POST, 'tagline');
    $blogUrl  = filter_input(INPUT_POST, 'blogUrl');
    $language = filter_input(INPUT_POST, 'language');
    $footer   = filter_input(INPUT_POST, 'footer');

    $pdo = getPdoConnection();

    $sql = 'UPDATE `settings` SET `title`=:title,
        `tagline`=:tagline,
        `theme`=:theme,
        `blog_url`=:blog_url,
        `lang_short`=:language,
        `footer`=:footer WHERE 1';

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':blog_url', $blogUrl);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':footer', $footer);

        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }

    header ( "Location: index.php?uri=general" );
}
