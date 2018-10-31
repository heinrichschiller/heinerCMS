<?php

function index()
{
    $templateList = [
        'navigation' => 'navigation.phtml',
        'dashboard'  => 'dashboard.phtml'
    ];
    
    return render($templateList);
}

function settings()
{
    $templateList = [
        'navigation' => 'navigation.phtml',
        'dashboard'  => 'settings.phtml'
    ];
    
    return render($templateList);
}