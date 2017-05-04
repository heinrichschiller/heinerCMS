<?php

class Db_Installer {

    /**
     * Database adapter
     * 
     * @var null
     */
	private $_pdo = null;

	public function __construct(PDO $pdo) {
		$this->_pdo = $pdo;
	}

	/**
	 * Create the database
	 * 
	 * @param string $database - Name of the database
	 */
	public function createDatabase($database) {
		$sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		
		$this->_pdo->exec($sql);
	}

	/**
	 * Create table Articles
	 */
	public function createTableArticles() {
		$sql = "CREATE TABLE `articles` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(64) NOT NULL DEFAULT '',
			`content` LONGTEXT NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`update_at` timestamp NULL DEFAULT NULL,
			`nextPageId` INT NOT NULL DEFAULT '-1',
			`visible` TINYINT(4) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
			) CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		
		$this->_pdo->exec($sql);
	}

	/**
	 * Create table Downloads
	 */
	public function createTableDownloads() {
		$sql = "CREATE TABLE `downloads` (
		    `id` INT NOT NULL AUTO_INCREMENT,
		    `title` VARCHAR(64) NOT NULL DEFAULT '',
		    `comment` TEXT NOT NULL,
		    `path` VARCHAR(128) NOT NULL DEFAULT '',
		    `filename` VARCHAR(64) NOT NULL DEFAULT '',
		    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		    `update_at` timestamp NULL DEFAULT NULL,
		    `visible` TINYINT(4) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`id`)
		   ) CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		
		$this->_pdo->exec($sql);
	}

	/**
	 * Create table Links
	 */
	public function createTableLinks() {
		$sql = "CREATE TABLE `links` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(64) NOT NULL DEFAULT '',
			`uri` VARCHAR(255) NOT NULL DEFAULT 'http://',
			`comment` TEXT NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`update_at` timestamp NULL DEFAULT NULL,
			`visible` TINYINT(4) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
			) CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		
		$this->_pdo->exec($sql);
	}

	/**
	 * Create table News
	 */
	public function createTableNews() {
		$sql = "CREATE TABLE `news` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(64) NOT NULL DEFAULT '',
			`message` TEXT NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`update_at` timestamp NULL DEFAULT NULL,
			`visible` TINYINT(4) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
			) CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		
		$this->_pdo->exec($sql);
	}

	/**
	 * Create table Users
	 */
	public function createTableUsers() {
		$sql = "CREATE TABLE `users` (
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
			) CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		
		$this->_pdo->exec($sql);
	}

	/**
	 * Select a database by his name
	 * 
	 * @param string $database
	 */
	public function selectDatabase($database) {
	    $sql = "USE `$database`";

		$this->_pdo->exec($sql);
	}
	
}