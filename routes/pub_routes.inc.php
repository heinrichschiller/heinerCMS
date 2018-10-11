<?php

$route = [];

$route['downloads'] = function()
{
    return load_downloads();
};

$route['downloadsdet'] = function($id)
{
    return load_downloadsdetailed($id);
};

$route['articles'] = function()
{
    return renderArticlesPage();
};

$route['articlesdet'] = function($id)
{
    return load_articles_detailed($id);
};

$route['links'] = function()
{
    return load_links();
};

$route['pages'] = function($id)
{
    return load_pages($id);
};

$route['mainpage'] = function() {
    return load_mainpage();
};

$route['admin'] = function()
{
    header('Location: admin/index.php');
};