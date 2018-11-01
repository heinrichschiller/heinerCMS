<?php

function indexAction()
{
    $templateList = [
        'navigation' => 'navigation.phtml',
        'dashboard'  => 'dashboard.phtml'
    ];
    
    return render($templateList);
}

function settingsAction()
{
    $templateList = [
        'navigation' => 'navigation.phtml',
        'dashboard'  => 'settings.phtml'
    ];
    
    return render($templateList);
}