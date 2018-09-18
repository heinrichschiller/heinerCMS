<?php

/****************************************************************************************
 *
 * The base configuration for heinerCMS.
 *
 * This file contains:
 *
 * * 
 * * 
 *
 * @since 0.5.0
 *
 ***************************************************************************************/

/**
 * Path to config directory
 * 
 * @var string
 * @since 0.5.0
 */
define('CONFIG_PATH', __DIR__ . '/');

/**
 * Path to include directory
 * 
 * @var string
 * @since 0.5.0
 */
define('INCLUDE_PATH', __DIR__ . '/../include/');

/**
 * Path to img_svg directory
 *
 * @var string
 * @since 0.5.0
 */
define('IMG_SVG_PATH', __DIR__ . '/../templates/default/admin/img/svg/');

/**
 * Path to locales directory
 *
 * @var string
 * @since 0.5.0
 */
define('LOCALES_PATH', __DIR__ . '/../locales/');

/****************************************************************************************
 * Debuging options for heinerCMS
 ***************************************************************************************/

/**
 * Set error handling for development and debugging on heinerCMS.  It can be set in
 * cms-config.php
 *
 * @var string Set the value on 'true' to activate the debug mode
 * 
 * @since 0.8.0
 */
define('DEBUG_MODE', false);
