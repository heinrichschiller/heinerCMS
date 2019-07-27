<?php

/**
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * MIT License
 *
 * Copyright (c) 2017 - 2019 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 *
 * The base configuration for heinerCMS.
 *
 * This file contains:
 *
 * * some path constants
 * * debugging options for heinerCMS
 *
 * @since 0.5.0
 *
 **/

/**
 * Path to the SVG images.
 *
 * @var string
 *
 * @since 0.9.0
 */
define('SVG_PATH', BASE_URL . 'public/assets/img/svg/');

/**
 * Source path of heinerCMS.
 *
 * @var string
 * @since 0.9.0
 */
define('CMS_SRC_PATH', ROOT_PATH . 'src/');

/**
 * Path to config directory.
 *
 * @var string
 * @since 0.5.0
 */
define('CMS_CONFIG_PATH', CMS_SRC_PATH . 'configs/');

/**
 * Path to lib directory
 *
 * @var string
 * @since 0.9.0
 */
define('CMS_LIB_PATH', CMS_SRC_PATH . '/lib/');

/**
 * Path to locales directory
 *
 * @var string
 * @since 0.5.0
 */
define('CMS_LOCALES_PATH', CMS_SRC_PATH . 'locales/');

/**
 * Path to modules directory
 *
 * @var string
 *
 * @since 0.9.0
 */
define('CMS_MODULES_PATH', CMS_SRC_PATH . 'modules/');

/**
 * Path to modules directory
 *
 * @var string
 *
 * @since 0.9.0
 */
define('CMS_TEMPLATES_PATH', CMS_SRC_PATH . 'templates/');

/*******************************************************************************
 * Debuging options for heinerCMS
 ******************************************************************************/

/**
 * Set error handling for development and debugging on heinerCMS.  It can be set in
 * cms-config.php
 *
 * @var string Set the value on 'true' to activate the debug mode
 *
 * @since 0.8.0
 */
define('DEBUG_MODE', false);

/**
 * Set error handling for development and debugging on PDO connection. It can be set in
 * cms-config.php.
 *
 * @since 0.2.3
 * @var string Set the value on 'true' to activate the debug mode
 */
define('PDO_DEBUG_MODE', false);
