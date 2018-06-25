<?php

$route = [];

/************************************************************
 * news routes
 ***********************************************************/

$route['news'] = function($id) {
    return load_news();
};

$route['newsedit'] = function($id) {
    return load_news_edit ($id);
};

$route['newsadd'] = function($id) {
    return load_news_add($id);
};

$route['newsdel'] = function($id) {
    return load_news_del($id);
};

$route['newssettings'] = function() {
    return load_news_settings();
};

/************************************************************
 * downloads routes
 ***********************************************************/

$route['downloads'] = function($id) {
    return load_downloads();
};

$route['downloadsedit'] = function($id) {
    return load_downloads_edit($id);
};

$route['downloadsadd'] = function($id) {
    return load_downloads_add($id);
};

$route['downloadsdel'] = function($id) {
    return load_downloads_del($id);
};

$route['downloadssettings'] = function($id) {
    return load_downloads_settings();
};

/************************************************************
 *  links routes
 ***********************************************************/

$route['links'] = function($id) {
    return load_links();
};

$route['linkedit'] = function($id) {
    return load_link_edit($id);
};

$route['linkadd'] = function($id) {
    return load_link_add($id);
};

$route['linkdel'] = function($id) {
    return load_link_del($id);
};

$route['linksettings'] = function() {
    return load_link_settings();
};

/************************************************************
 * articles routes
 ***********************************************************/

$route['articles'] = function($id) {
    return load_articles($id);
};

$route['articleedit'] = function($id) {
    return load_article_edit($id);
};

$route['articleadd'] = function($id) {
    return load_article_add($id);
};

$route['articledel'] = function($id) {
    return load_article_del($id);
};

$route['articlessettings'] = function() {
    return load_articles_settings();
};

/************************************************************
 * user routes
 ***********************************************************/
$route['user'] = function() {    
    return load_user_list();
};

$route['useredit'] = function($id) {
    return load_user_edit($id);
};

$route['userinsert'] = function() {
    return load_user_add();
};

$route['userdel'] = function($id) {
    return load_user_del($id);
};

/************************************************************
 * pages routes
 ***********************************************************/

$route['pages'] = function() {
    return load_pages();
};

$route['pageadd'] = function() {
    return load_page_add();
};

$route['pageedit'] = function($id) {
    return load_page_edit($id);
};

$route['pagedel'] = function($id) {
    return load_page_del($id);
};

$route['mainpage'] = function() {
    return load_mainpage();  
};

/************************************************************
 * dashboard route
 ***********************************************************/

$route['dashboard'] = function() {
    return load_dashboard();
};

/************************************************************
 * trash route
 ***********************************************************/

$route['trash'] = function() {
    return load_trash();
};

/************************************************************
 * general settings route
 ***********************************************************/
$route['general'] = function() {
    return load_general_settings();
};

/************************************************************
 * other routes
 ***********************************************************/
$route['logout'] = function() {
    header ('Location: logout.php');
};

$route['communication'] = function() {
    return load_communication();
};