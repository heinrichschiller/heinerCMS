<?php

/* Konfigurationsvariablen */
$base['title'] = 'Heinrich-Schiller.de';
$base['navigation'] = '<li><a href="http://heinrich-schiller.de/wordpress/" target="blank">Blog</a></li>
    <li><a href="$PHP_SELF?uri=news">News</a></li>
    <li><a href="$PHP_SELF?uri=downloads">Gallerie</a></li>
    <li><a href="$PHP_SELF?uri=aboutme">Über mich</a></li>
    <li><a href="$PHP_SELF?uri=contact">Impressum</a></li>';
$base['content'] = '';
$base['template'] = 'templates/pub_template.php';

$base['adm_title'] = 'heinerCMS - Administration';
$base['adm_navigation'] = '<div class="list-group">
    <a href="$PHP_SELF?uri=dashboard" class="list-group-item">
        <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard
    </a>
    </div>
    <div class="list-group">
    <li class="list-group-item active">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Content
    </li>
    <a href="$PHP_SELF?uri=news" class="list-group-item">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> News
        <span class="badge">0</span>
    </a>
    <a href="$PHP_SELF?uri=downloads" class="list-group-item">
        <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Downloads
        <span class="badge">0</span>
    </a>
    <a href="$PHP_SELF?uri=links" class="list-group-item">
        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Links
        <span class="badge">0</span>
    </a>
    <a href="$PHP_SELF?uri=articles" class="list-group-item">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Articles
        <span class="badge">0</span>
    </a>
    </div>
    <div class="list-group">
        <li class="list-group-item active">
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Settings
        </li>
        <a href="$PHP_SELF?uri=general" class="list-group-item">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> General
        </a>
        <a href="$PHP_SELF?uri=user" class="list-group-item">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> User
        </a>
    </div>';
$base['adm_content'] = '';
$base['adm_actual'] = 'Sie sind hier: ';

// config.ini for heinercms
$config_ini = __DIR__ . '/../source/configs/config.ini';


