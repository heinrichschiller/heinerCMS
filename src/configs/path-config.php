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
 * *
 * *
 *
 * @since 0.5.0
 *
 **/

/**
 * Base url of heinerCMS.
 *
 * @var string
 *
 * @since 0.9.0
 */
define('BASE_URL', 'http://heinercms.localhost/');

/**
 * Path to the SVG images.
 *
 * @var $xmlString*
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
define('SRC_PATH', ABS_PATH . 'src/');

/**
 * Path to config directory.
 *
 * @var string
 * @since 0.5.0
 */
define('CONFIG_PATH', SRC_PATH . 'configs/');

/**
 * Path to lib directory
 *
 * @var string
 * @since 0.9.0
 */
define('LIB_PATH', SRC_PATH . '/lib/');

/**
 * Path to locales directory
 *
 * @var string
 * @since 0.5.0
 */
define('LOCALES_PATH', SRC_PATH . 'locales/');

/**
 * Path to modules directory
 *
 * @var string
 *
 * @since 0.9.0
 */
define('MODULES_PATH', SRC_PATH . 'modules/');
