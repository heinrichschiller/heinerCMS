<?php

$route = [];

$route['news'] = function()
{
    return load_public_news();
};

$route['newsdet'] = function($id)
{
    return load_public_newsdetailed($id);
};

$route['downloads'] = function()
{
    return load_public_downloads();
};

$route['downloadsdet'] = function($id)
{
    return load_public_downloadsdetailed($id);
};

$route['articles'] = function()
{
    return load_public_articles();
};

$route['articlesdet'] = function($id)
{
    return load_public_articlesdetailed($id);
};

$route['links'] = function()
{
    return load_public_links();
};

$route['admin'] = function()
{
    header('Location: admin/index.php');
};
