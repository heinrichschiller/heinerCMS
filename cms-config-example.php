<?php

/**
 * Driver for the database. Type can be mysql or sqlite server.
 * 
 * mysql - Supports MySQL or MariaDB database. It can be used, if you have
 * MySQL or MariaDB Server. Otherwise you can try SQLite, if your Server supports that. 
 * 
 * @since 0.2.3 
 * @var string Type of the database.
 */
define('DB_DRIVER', 'sqlite');

/**
 * 
 * @var unknown
 */
define('DB_NAME', __DIR__ . '/data/sqlite/heinercms.db');

/**
 * Set error handling for development and debugging.
 * 
 * @var string Set the value on 'On' to activate the debug mode
 */
define('PDO_DEBUG_MODE', 'Off');

/**
 * MySQL settings - if needed ...
 * 
 * @deprecated
 */

/**
 * Hostname of the mysql server.
 * 
 * @var string Hostname of the mysql server.
 */
//define('DB_HOST', 'localhost');

/**
 * MySQL database username.
 * 
 * @var string MySQL database username.
 */
//define('DB_USER', 'root');

/**
 * The name of the database.
 * 
 * @var type The name of the database.
 */
//define('DB_NAME', 'cms_heinercms');

/**
 * MySQL database password.
 * 
 * @var string MySQL database password.
 */
//define('DB_PASSWORD', '');

?>