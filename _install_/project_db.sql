CREATE DATABASE `heinercms` CHARSET=utf8 COLLATE=utf8_unicode_ci;

USE heinercms;

CREATE TABLE `articles` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL DEFAULT '',
  content LONGTEXT NOT NULL,
  datetime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  nextPageId INT NOT NULL DEFAULT '-1',
  visible TINYINT(4) NOT NULL DEFAULT '0'
);

CREATE TABLE `downloads` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL DEFAULT '',
  comment TEXT NOT NULL,
  path VARCHAR(128) NOT NULL DEFAULT '',
  filename VARCHAR(64) NOT NULL DEFAULT '',
  datetime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  visible TINYINT(4) NOT NULL DEFAULT '0'
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `links` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL DEFAULT '',
  uri VARCHAR(255) NOT NULL DEFAULT 'http://',
  comment TEXT NOT NULL,
  visible TINYINT(4) NOT NULL DEFAULT '0'
);

CREATE TABLE news (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(64) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  datetime DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  visible TINYINT(4) NOT NULL DEFAULT '0'
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` VARCHAR(64) NOT NULL,
  `active` ENUM('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`),
  UNIQUE (`username`),
  UNIQUE (`email`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci;
