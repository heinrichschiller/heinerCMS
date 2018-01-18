<?php

/* Konfigurationsvariablen */
$base['title'] = 'Heinrich-Schiller.de';
$base['navigation'] = '<li><a href="'. getBlogURL() .'" target="blank">Blog</a></li>
    <li><a href="$PHP_SELF?uri=news">News</a></li>
    <li><a href="$PHP_SELF?uri=downloads">Downloads</a></li>
    <li><a href="$PHP_SELF?uri=links">Links</a></li>
    <li><a href="$PHP_SELF?uri=articles">Artikel</a></li>';
$base['content'] = '';
$base['template'] = 'templates/bootstrap-3.3.7/pub_template.tpl.php';

$base['adm_title'] = 'heinerCMS';

// config.ini for heinercms
$config_ini = __DIR__ . '/../source/configs/config.ini';
