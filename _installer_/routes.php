<?php

$route = [];

$route['start'] = function() {
    return load_start();
};

$route['language'] = function() {
    return load_language();
};

$route['licence'] = function() {
    return load_licence();
};

$route['conditions'] = function() {
    return load_conditions();
};

$route['database'] = function() {
    return load_database();
};

$route['user'] = function() {
    return load_user();
};

$route['installation'] = function() {
    return load_installation();
};

$route['final'] = function() {
    return load_final();
};
