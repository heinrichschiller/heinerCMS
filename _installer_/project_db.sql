-- please set a new name for the database
CREATE DATABASE `heinercms` CHARSET=utf8 COLLATE=utf8_unicode_ci;

USE heinercms;

CREATE TABLE `articles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL DEFAULT '',
  `content` LONGTEXT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `nextPageId` INT NOT NULL DEFAULT '-1',
  `visible` TINYINT(4) NOT NULL DEFAULT '0',
  `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `articles_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tagline` VARCHAR(100) NOT NULL DEFAULT '',
  `comment` TEXT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,  
  PRIMARY KEY (`id`)
  ) CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- tables:
CREATE TABLE `downloads` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL DEFAULT '',
  `comment` TEXT NOT NULL,
  `path` VARCHAR(128) NOT NULL DEFAULT '',
  `filename` VARCHAR(64) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `visible` TINYINT(4) NOT NULL DEFAULT '0',
  `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `downloads_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tagline` VARCHAR(100) NOT NULL DEFAULT '',
  `comment` TEXT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,  
  PRIMARY KEY (`id`)
  ) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `links` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL DEFAULT '',
  `tagline` VARCHAR(100) NOT NULL DEFAULT '',
  `uri` VARCHAR(255) NOT NULL DEFAULT 'http://',
  `comment` TEXT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,  
  `visible` TINYINT(4) NOT NULL DEFAULT '0',
  `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `links_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tagline` VARCHAR(100) NOT NULL DEFAULT '',
  `comment` TEXT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,  
  PRIMARY KEY (`id`)
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

CREATE TABLE `sites` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) NOT NULL DEFAULT '',
  `tagline` VARCHAR(140) NOT NULL DEFAULT '',
  `content` LONGTEXT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `visible` TINYINT(4) NOT NULL DEFAULT '0',
  `trash` ENUM('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `settings` (
  `title` VARCHAR(64) NOT NULL DEFAULT '',
  `tagline` VARCHAR(140) NOT NULL DEFAULT '',
  `theme` VARCHAR(64) NOT NULL DEFAULT '',
  `blog_url` VARCHAR(140) NOT NULL DEFAULT '',
  `lang_short` VARCHAR(3) NOT NULL DEFAULT ''
) CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- default configuration

INSERT INTO `settings`(`title`, `tagline`, `theme`, `blog_url`, `lang_short`)
VALUES ('heinerCMS', '', 'default', '', '');

INSERT INTO `links_settings`(`tagline`, `comment`)
VALUES ('','');

INSERT INTO `news_settings`(`tagline`, `comment`)
VALUES ('','');

INSERT INTO `articles_settings`(`tagline`, `comment`)
VALUES ('','');

INSERT INTO `downloads_settings`(`tagline`, `comment`)
VALUES ('','');
