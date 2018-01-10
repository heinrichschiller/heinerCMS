<?php

$route = [];

$route['news'] = function($id) {
	return load_admin_news ();
};

$route['newsedit'] = function($id) {
	return load_admin_news_edit ($id);
};

$route['newsadd'] = function($id) {
	return load_admin_news_add($id);
};

$route['newsdel'] = function($id) {
	return load_admin_news_del($id);
};

$route['downloads'] = function($id) {
	return load_admin_downloads();
};

$route['downloadsedit'] = function($id) {
	return load_admin_downloads_edit($id);
};

$route['downloadsadd'] = function($id) {
	return load_admin_downloads_add($id);
};

$route['downloadsdel'] = function($id) {
	return load_admin_downloads_del($id);
};

$route['links'] = function($id) {
	return load_admin_links();
};

$route['linkedit'] = function($id) {
	return load_admin_link_edit($id);
};

$route['linkadd'] = function($id) {
	return load_admin_link_add($id);
};

$route['linkdel'] = function($id) {
	return load_admin_link_del($id);
};

$route['articles'] = function($id) {
	return load_admin_articles($id);
};

$route['articleedit'] = function($id) {
	return load_admin_article_edit($id);
};

$route['articleadd'] = function($id) {
	return load_admin_article_add($id);
};

$route['articledel'] = function($id) {
	return load_admin_article_del($id);
};

$route['dashboard'] = function() {
    return load_dashboard();
};

$route['trash'] = function() {
    return load_trash();
};

$route['general'] = function() {
    return load_general_settings();
};

$route['user'] = function() {    
    return load_user_list();
};

$route['useredit'] = function($id) {
    return load_user_edit($id);
};

$route['userinsert'] = function() {
    return load_user_insert();
};

$route['logout'] = function() {
	header ('Location: logout.php');
};