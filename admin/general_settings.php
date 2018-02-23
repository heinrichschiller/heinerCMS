<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

if (is_logged_in()) {
    
    $title = filter_input(INPUT_POST, 'title');
    $theme = filter_input(INPUT_POST, 'theme');
    $tagline = filter_input(INPUT_POST, 'tagline');
    $blogUrl = filter_input(INPUT_POST, 'blogUrl');
    
    $pdo = getPdoDB();
    
    $sql = 'UPDATE `settings` SET `title`=:title,`tagline`=:tagline,`theme`=:theme,`blog_url`=:blog_url WHERE 1';
        
    $input_parameters = [
        ':title'   => $title,
        ':tagline' => $tagline,
        ':theme' => $theme,
        ':blog_url' => $blogUrl
    ];

    try {
            
        $stmt = $pdo->prepare($sql);
        $stmt->execute($input_parameters);
            
    } catch (Exception $ex) {
            
        echo $ex->getMessage();
        exit();
            
    }
    
    header ( "Location: index.php?uri=general" );
}
