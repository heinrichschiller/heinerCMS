<?php

function indexAction()
{
    $templateList = [
        'dashboard'  => 'dashboard.phtml'
    ];
    
    return render($templateList);
}

function settingsAction()
{
    $templateList = [
        'dashboard'  => 'settings.phtml'
    ];
    
    return render($templateList);
}