<?php

/* Konfigurationsvariablen */
$base['title'] = 'Heinrich-Schiller.de';
$base['navigation'] = '<li><a href="http://heinrich-schiller.de/wordpress/" target="blank">Blog</a></li>
    <li><a href="$PHP_SELF?uri=news">News</a></li>
    <li><a href="$PHP_SELF?uri=downloads">Gallerie</a></li>
    <li><a href="$PHP_SELF?uri=aboutme">Über mich</a></li>
    <li><a href="$PHP_SELF?uri=contact">Impressum</a></li>';
$base['content'] = '';
$base['template'] = 'templates/main.htm';

$base['adm_title'] = 'heinerCMS - Administration';
$base['adm_navigation'] = '<div class="list-group">
  <a href="$PHP_SELF?uri=news" class="list-group-item">News<span class="badge">0</span></a>
  <a href="$PHP_SELF?uri=downloads" class="list-group-item">Downloads<span class="badge">0</span></a>
  <a href="$PHP_SELF?uri=links" class="list-group-item">Links<span class="badge">0</span></a>
  <a href="$PHP_SELF?uri=articles" class="list-group-item">Articles<span class="badge">0</span></a>
</div>';
$base['adm_content'] = '';
$base['adm_actual'] = 'Sie sind hier: ';

// config.ini for heinercms
$config_ini = __DIR__ . '/../source/config.ini';


