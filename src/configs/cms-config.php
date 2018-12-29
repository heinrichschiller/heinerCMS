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

include_once __DIR__ . '/path-config.php';
include_once __DIR__ . '/db-config.php';
include_once LIB_PATH . 'session-functions.php';
include_once LIB_PATH . 'general-functions.php';
include_once LIB_PATH . DB_DRIVER . '_db_functions.inc.php';

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

/**
 * Set error handling for development and debugging on PDO connection. It can be set in
 * cms-config.php.
 *
 * @since 0.2.3
 * @var string Set the value on 'true' to activate the debug mode
 */
define('PDO_DEBUG_MODE', false);
