<?php

$route = [];

$route['news'] = function()
{
    return load_content_news();
};

$route['newsdet'] = function($id)
{
    return load_content_newsdetailed($id);
};

$route['downloads'] = function()
{
    return load_content_downloads();
};

$route['downloadsdet'] = function($id)
{
    return load_content_downloadsdetailed($id);
};

$route['articles'] = function()
{
    return load_content_articles();
};

$route['articlesdet'] = function($id)
{
    return load_content_articlesdetailed($id);
};

$route['links'] = function()
{
    return load_content_links();
};

$route['admin'] = function()
{
    header('Location: admin/index.php');
};
