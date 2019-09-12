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

function initSession()
{
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Load a session for heinerCMS.
 *
 * @since 0.9.0
 */
function setSession()
{
    initSession();

    $settings = getGeneralSettings();

    $_SESSION['title']    = $settings['title'];
    $_SESSION['tagline']  = $settings['tagline'];
    $_SESSION['theme']    = $settings['theme'];
    $_SESSION['darkmode'] = $settings['darkmode'];
    $_SESSION['blog-url'] = $settings['blog_url'];
    $_SESSION['language'] = $settings['lang_short'];
    $_SESSION['footer']   = $settings['footer'];
}

function isLoggedIn()
{
    initSession();
    if(isset($_SESSION['id'])) {
        return true;
    }
    return false;
}

function checkLogin()
{
    if (!isLoggedIn()) {
        redirect('public/index');
        exit;
    }
}

function logout()
{
    initSession();

    $_SESSION ['authenticated'] = false;
    $_SESSION ['username'] = '';
    $_SESSION ['user_id'] = '';

    session_destroy();

    redirect('user/goodbye');
}

function login(string $email, string $password)
{
    initSession();
    setSession();

    $user = authUser($email, $password);

    if($user) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['id'] = $user['id'];

        return true;
    }

    return false;
}
