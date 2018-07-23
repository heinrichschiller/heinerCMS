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
define('DB_NAME', __DIR__ . '/../data/sqlite/heinercms.db');

/****************************************************************************************
 * Debuging options for heinerCMS
 ***************************************************************************************/

/**
 * Set error handling for development and debugging on PDO connection. It can be set in
 * cms-config.php.
 *
 * @since 0.2.3
 * @var string Set the value on 'true' to activate the debug mode
 */
define('PDO_DEBUG_MODE', false);

?>