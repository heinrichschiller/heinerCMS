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

 if(!defined('UPLOAD_PATH')) {

     /**
      * Path to modules/public/
      *
      * @var string
      *
      * @since 0.9.0
      */
     define('UPLOAD_PATH', __DIR__ . '/');
 }

 if(!defined('UPLOAD_LIB_PATH')) {

     /**
      * Path to modules/public/lib/
      *
      * @var string
      *
      * @since 0.9.0
      */
     define('UPLOAD_LIB_PATH', __DIR__ . '/lib/');
 }

 include UPLOAD_LIB_PATH . DB_DRIVER .'-functions.php';
 include UPLOAD_LIB_PATH . 'actions.php';
 include UPLOAD_LIB_PATH . 'functions.php';
