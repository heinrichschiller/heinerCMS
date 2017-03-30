<?php

error_reporting(-1);
ini_set('display_errors', true);

$uri = filter_input(INPUT_GET, 'uri');
$id  = filter_input(INPUT_GET, 'id');
  

include 'inc/base.inc.php';
include 'inc/database.inc.php';
include 'inc/functions.inc.php';
include 'inc/router.php';


/* Template einlesen  */
//$template = get_file_as_string($base['template']);
$template = file_get_contents($base['template']);
  
/* Inhalt laden */
/*switch(strtolower($cmd)) {
    default:
    case 'news':
        $base['content'] = '<h4>'.$base['actual'].'<i>News</i></h4>';
        $base['content'] .= load_content_news();
        break;
    case 'newsdet':
        $base['content'] = '<h4>'.$base['actual'].'<i>News / Detailansicht</i></h4>';
        $base['content'] .= load_content_newsdetailed($id);
        break;
    case 'downloads':
        $base['content'] = '<h4>'.$base['actual'].'<i>Downloads</i></h4>';
        $base['content'] .= load_content_downloads();
        break;
    case 'downloadsdet':
        $base['content'] = '<h4>'.$base['actual'].'<i>Downloads / Detailansicht</i></h4>';
        $base['content'] .= load_content_downloadsdetailed($id);
        break;
    case 'articles':
        $base['content'] = '<h4>'.$base['actual'].'<i>Artikel</i></h4>';
        $base['content'] .= load_content_articles();
        break;
    case 'articlesdet':
        $base['content'] = '<h4>'.$base['actual'].'<i>Artikel / Detailansicht</i></h4>';
        $base['content'] .= load_content_articlesdetailed($id);
        break;
    case 'links':
        $base['content'] = '<h4>'.$base['actual'].'<i>Links</i></h4>';
        $base['content'] .= load_content_links();
        break;
    case 'admin':
        header('Location: admin/index.php');
        break;
}
*/ 

if (isset($route[$uri]) ) {
    $base['content'] .= $route[$uri]();
}
 

$template = str_replace('###title###',$base['title'],$template);
$template = str_replace('###navigation###',$base['navigation'],$template);
$template = str_replace('###content###',$base['content'],$template);
$template = str_replace('$PHP_SELF',$_SERVER['PHP_SELF'],$template);
  

echo stripslashes($template);


