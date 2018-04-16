<?php

include __DIR__ . '/../cms-config.php';

include __DIR__ . '/../include/pdo_db_functions.inc.php';
include __DIR__ . '/../include/general_functions.inc.php';
include __DIR__ . '/../include/login.inc.php';

if (is_logged_in()) {
    
    $title    = filter_input(INPUT_POST, 'title');
    $theme    = filter_input(INPUT_POST, 'theme');
    $tagline  = filter_input(INPUT_POST, 'tagline');
    $blogUrl  = filter_input(INPUT_POST, 'blogUrl');
    $language = filter_input(INPUT_POST, 'language');
    $footer   = filter_input(INPUT_POST, 'footer');
    
    $pdo = getPdoDB();
    
    $sql = 'UPDATE `settings` SET `title`=:title,`tagline`=:tagline,`theme`=:theme,`blog_url`=:blog_url, `lang_short`=:language, `footer`=:footer WHERE 1';
        
    $input_parameters = [
        ':title'    => $title,
        ':tagline'  => $tagline,
        ':theme'    => $theme,
        ':blog_url' => $blogUrl,
        ':language' => $language,
        ':footer'   => $footer
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
