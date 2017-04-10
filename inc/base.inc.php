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
//$base['adm_shortnav'] = '<a href="$PHP_SELF?uri=news">News</a> &middot; <a href="$PHP_SELF?uri=downloads">Downloads</a> &middot; <a href="logout.php">Logout</a>';
// $base['adm_navigation'] = '<a href="$PHP_SELF?uri=news">News</a><br><a href="$PHP_SELF?uri=downloads">Downloads</a><br><a href="$PHP_SELF?uri=links">Links</a><br><a href="$PHP_SELF?uri=articles">Artikel</a><br><br><a href="logout.php" class="red">Logout</a>';
$base['adm_navigation'] = '<div class="list-group">
  <a href="$PHP_SELF?uri=news" class="list-group-item">News<span class="badge">0</span></a>
  <a href="$PHP_SELF?uri=downloads" class="list-group-item">Downloads<span class="badge">0</span></a>
  <a href="$PHP_SELF?uri=links" class="list-group-item">Links<span class="badge">0</span></a>
  <a href="$PHP_SELF?uri=articles" class="list-group-item">Articles<span class="badge">0</span></a>
</div>';
$base['adm_content'] = '';
$base['adm_actual'] = 'Sie sind hier: ';
$base['adm_template'] = '../templates/admmain.htm';

/* Hilfsfunktionen */

/* Datei als String einlesen */
function get_file_as_string($filename)
{
    $tmprslt = file($filename);
    $tmprslt = implode('',$tmprslt);
    return $tmprslt;
}


