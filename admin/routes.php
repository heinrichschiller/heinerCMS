<?php

$route = [];

$route['news'] = function($id) {
	return load_admin_news ();
};

$route['newsedit'] = function($id) {
	return load_admin_newsedit ($id);
};

$route['newsadd'] = function($id) {
	return load_admin_newsadd($id);
};

$route['newsdel'] = function($id) {
	return load_admin_newsdel($id);
};

$route['downloads'] = function($id) {
	return load_admin_downloads();
};

$route['downloadsedit'] = function($id) {
	return load_admin_downloadsedit($id);
};

$route['downloadsadd'] = function($id) {
	return load_admin_downloadsadd($id);
};

$route['downloadsdel'] = function($id) {
	return load_admin_downloadsdel($id);
};

$route['links'] = function($id) {
	return load_admin_links();
};

$route['linkedit'] = function($id) {
	return load_admin_linkedit($id);
};

$route['linkadd'] = function($id) {
	return load_admin_linkadd($id);
};

$route['linkdel'] = function($id) {
	return load_admin_linkdel($id);
};

$route['articles'] = function($id) {
	return load_admin_articles($id);
};

$route['articleedit'] = function($id) {
	return load_admin_articleedit($id);
};

$route['articleadd'] = function($id) {
	return load_admin_articleadd($id);
};

$route['articledel'] = function($id) {
	return load_admin_articledel($id);
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