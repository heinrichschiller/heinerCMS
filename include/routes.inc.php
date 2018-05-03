<?php

$route = [];

$route['news'] = function()
{
    return load_news();
};

$route['newsdet'] = function($id)
{
    return load_news_detailed($id);
};

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
    return load_articles();
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