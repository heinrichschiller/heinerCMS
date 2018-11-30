<?php

/**
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * MIT License
 *
 * Copyright (c) 2017 - 2018 Heinrich Schiller
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
define('BASE_URL', '');

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
 * Path to img_svg directory
 *
 * @var string
 * @since 0.5.0
 */
define('IMG_SVG_PATH', SRC_PATH . '/../templates/default/admin/img/svg/');

/**
 * Path to locales directory
 *
 * @var string
 * @since 0.5.0
 */
define('LOCALES_PATH', SRC_PATH . 'locales/');

/**
 * Path to modules/admin/.
 *
 * @var string
 * @since 0.9.0
 */
define('ADMIN_PATH', SRC_PATH . 'admin/');

/**
 * Path to modules/admin/lib/.
 *
 * @var string
 * @since 0.9.0
 */
define('ADMIN_LIB_PATH', SRC_PATH . 'admin/lib/');

/**
 * Path to modules/article/.
 *
 * @var string
 * @since 0.9.0
 */
define('ARTICLE_PATH', SRC_PATH . 'article/');

/**
 * Path to modules/article/lib/.
 *
 * @var string
 * @since 0.9.0
 */
define('ARTICLE_LIB_PATH', SRC_PATH . 'article/lib/');

/**
 * Path to modules/download/.
 *
 * @var unknown
 * @since 0.9.0
 */
define('DOWNLOAD_PATH', SRC_PATH . 'download/');

/**
 * Path to modules/download/lib/.
 *
 * @var string
 * @since 0.9.0
 */
define('DOWNLOAD_LIB_PATH', SRC_PATH . 'download/lib/');

/**
 * Path to modules/link/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('LINK_PATH', SRC_PATH . 'link/');

/**
 * Path to modules/link/lib/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('LINK_LIB_PATH', SRC_PATH . 'link/lib/');

/**
 * Path to modules/page/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('PAGE_PATH', SRC_PATH . 'page/');

/**
 * Path to modules/page/lib/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('PAGE_LIB_PATH', SRC_PATH . 'page/lib/');

/**
 * Path to modules/public/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('PUBLIC_PATH', SRC_PATH . 'public/');

/**
 * Path to modules/public/lib/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('PUBLIC_LIB_PATH', SRC_PATH . 'public/lib/');

/**
 * Path to modules/user/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('USER_PATH', SRC_PATH . 'user/');

/**
 * Path to modules/user/lib/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('USER_LIB_PATH', SRC_PATH . 'user/lib/');

/**
 * Path to modules/wastebin/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('WASTEBIN_PATH', SRC_PATH . 'wastebin/');

/**
 * Path to modules/wastebin/lib/
 *
 * @var string
 *
 * @since 0.9.0
 */
define('WASTEBIN_LIB_PATH', SRC_PATH . 'wastebin/lib/');
