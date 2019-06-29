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
 * Database connection for heinerCMS that use PDO-Connection.
 *
 * @param string $driver Driver is mysql or sqlite.
 *
 * @return PDO
 *
 * @filesource /src/libs/database.php
 */
function getPdoConnection($driver = 'sqlite') : PDO
{
    $config = include ABS_PATH . 'src/configs/default.php';
    $path = ABS_PATH . 'src/database/sqlite/';

    try {
        if ($driver == 'mysql') {
            $pdo = new PDO( DB_DRIVER . ':host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASSWORD );
        } else {
            $pdo = new PDO($config['driver'] . ':' . $path . $config['name']);
        }

        if ( $config['pdo_debug_mode'] ) {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $pdo;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}
