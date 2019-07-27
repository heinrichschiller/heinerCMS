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

function indexAction()
{
    checkLogin();

    $templateList = [
        'dashboard'  => 'dashboard.phtml'
    ];

    return render($templateList);
}

function settingsAction()
{
    checkLogin();

    $templateList = [
        'settings.phtml'
    ];

    $locales = getLocales();
    $settings = getGeneralSettings();

    $itemList = [
        'locales'  => $locales,
        'settings' => $settings
    ];

    return render($templateList, $itemList);
}

function mainpageAction()
{
    checkLogin();

    $templateList = [
        'mainpage.phtml'
    ];

    return render($templateList);
}

function updateAction()
{
    $title    = filter_input(INPUT_POST, 'title');
    // $theme    = filter_input(INPUT_POST, 'theme');
    // $darkmode = filter_input(INPUT_POST, 'darkmode');
    $tagline  = filter_input(INPUT_POST, 'tagline');
    $blogUrl  = filter_input(INPUT_POST, 'blogUrl');
    $language = filter_input(INPUT_POST, 'language');
    $footer   = filter_input(INPUT_POST, 'footer');

    if(!isset($darkmode)) {
        $darkmode = '';
    }

    if(!isset($theme)) {
        $theme = 'default';
    }

    updateGeneralSettings($title, $tagline, $theme, $darkmode, $blogUrl, $language, $footer);

    setSession();

    redirectToAdmin();
}

function impressAction()
{
    checkLogin();

    $templateList = [
        'impress'  => 'impress.phtml'
    ];

    return render($templateList);
}
