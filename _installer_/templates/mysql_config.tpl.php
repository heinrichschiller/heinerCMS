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
define('DB_DRIVER', 'mysql');

/**
 * Hostname of the mysql server.
 *
 * @since 0.1.2
 * @var string Hostname of the mysql server.
 */
define('DB_HOST', '##placeholder_database_address##');

/**
 * MySQL database username.
 *
 * @since 0.1.2
 * @var string MySQL database username.
 */
define('DB_USER', '##placeholder_database_user##');

/**
 * The name of the database.
 *
 * @since 0.1.2
 * @var type The name of the database.
 */
define('DB_NAME', '##placeholder_database_name##');

/**
 * MySQL database password.
 *
 * @since 0.1.2
 * @var string MySQL database password.
 */
define('DB_PASSWORD', '##placeholder_database_password##');

/****************************************************************************************
 * Debuging options for heinerCMS
 ***************************************************************************************/

/**
 * Set error handling for development and debugging on PDO connection.  It can be set in
 * cms-config.php
 *
 * @since 0.2.3
 * @var string Set the value on 'On' to activate the debug mode
 */
define('PDO_DEBUG_MODE', false);

?>