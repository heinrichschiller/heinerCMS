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
 * Absolute path of heinerCMS
 * 
 * @var string
 * @since 0.9.0
 */
define('ABS_PATH', __DIR__ . '/../');

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

/**
 * Path to modules/article/.
 * 
 * @var string
 * @since 0.9.0
 */
//define('MODULES_ARTICLE_PATH', __DIR__ . '/../modules/article/');

/**
 * Path to modules/article/lib/.
 *
 * @var string
 * @since 0.9.0
 */
define('MODULES_ARTICLE_LIB_PATH', __DIR__ . '/../modules/article/lib/');

/**
 * Path to modules/download/.
 * 
 * @var unknown
 * @since 0.9.0
 */
// define('MODULES_DOWNLOAD_PATH', __DIR__ . '/../modules/download/');

/**
 * Path to modules/download/lib/.
 * 
 * @var string
 * @since 0.9.0
 */
define('MODULES_DOWNLOAD_LIB_PATH', __DIR__ . '/../modules/download/lib/');

/**
 * Path to modules/link/
 *  
 * @var string
 * 
 * @since 0.9.0
 */
// define('MODULES_LINK_PATH', __DIR__ . '/../modules/link/');

/**
 * Path to modules/link/lib/
 * 
 * @var string
 * 
 * @since 0.9.0
 */
define('MODULES_LINK_LIB_PATH', __DIR__ . '/../modules/link/lib/');

/**
 * Path to modules/page/
 * 
 * @var string
 * 
 * @since 0.9.0
 */
// define('MODULES_PAGE_PATH', __DIR__ . '/../modules/page/');

/**
 * Path to modules/page/lib/
 * 
 * @var string
 * 
 * @since 0.9.0
 */
define('MODULES_PAGE_LIB_PATH', __DIR__ . '/../modules/page/lib/');


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
define('DEBUG_MODE', true);
