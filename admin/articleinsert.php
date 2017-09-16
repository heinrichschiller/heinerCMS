<?php

include __DIR__ . '/../inc/base.inc.php';
include __DIR__ . '/../inc/functions.inc.php';
include __DIR__ . '/../inc/login.inc.php';

require __DIR__ . '/../source/controllers/articles/ArticleController.php';
require __DIR__ . '/../source/models/articles/ArticleModel.php';

/* Überprüfen ob Login erfolgt ist, ggf. Anmeldemöglichkeit bieten */

$con = getDB();

if (is_logged_in ()) {
    
    $model = new ArticleModel();
    $article = new ArticleController($con, $model);
    
    $model->setId(filter_input(INPUT_POST, 'id'));
    $model->setTitle(filter_input(INPUT_POST, 'title'));
    $model->setContent(filter_input(INPUT_POST, 'content'));
    $model->setVisible(filter_input(INPUT_POST, 'visible'));


    try {
        
        $article->add();
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    
    header ( 'Location: index.php?uri=articles' );
}

