<?php

/****************************************************************************************
 * 
 * The base configuration for heinerCMS.
 * 
 * This file contains:
 * 
 * * Database settings
 * * Debug mode settings
 * 
 * @since 0.1.2
 * 
 ***************************************************************************************/

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
 * Name of the SQLite database
 * 
 * @since 0.2.3
 * @var string Name of the SQLite database
 */
define('DB_NAME', __DIR__ . '/data/sqlite/heinercms.db');

/**
 * MySQL settings - if needed ...
 *
 * @deprecated
 */

/**
 * Hostname of the mysql server.
 *
 * @since 0.1.2
 * @var string Hostname of the mysql server.
 */
//define('DB_HOST', 'localhost');

/**
 * MySQL database username.
 *
 * @since 0.1.2
 * @var string MySQL database username.
 */
//define('DB_USER', 'root');

/**
 * The name of the database.
 *
 * @since 0.1.2
 * @var type The name of the database.
 */
//define('DB_NAME', 'cms_heinercms');

/**
 * MySQL database password.
 *
 * @since 0.1.2
 * @var string MySQL database password.
 */
//define('DB_PASSWORD', '');

/****************************************************************************************
 * Debuging options for heinerCMS
 ***************************************************************************************/

/**
 * Set error handling for development and debugging on PDO connection.
 * 
 * @since 0.2.3
 * @var string Set the value on 'On' to activate the debug mode
 */
define('PDO_DEBUG_MODE', false);

?>