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

function indexAction(): string
{
    checkLogin();

    $linkList = getAllLinks();

    $templateList = [
        'links.phtml'
    ];

    return render($templateList, ['links' => $linkList]);
}

function editAction(array $params): string
{
    checkLogin();

    $linkItems = getLinkById($params['1']);

    $templateList = [
        'link.phtml'
    ];

    return render($templateList, ['link' => $linkItems]);
}

function newAction(): string
{
    checkLogin();

    $templateList = [
        'link.phtml'
    ];

    return render($templateList);
}

function settingsAction(): string
{
    checkLogin();

    $settingsItems = getLinksSettings();

    $templateList = [
        'link-settings.phtml'
    ];

    return render($templateList, ['settings' => $settingsItems]);
}

function updatesettingsAction()
{
    checkLogin();

    $tagline = filter_input(INPUT_POST, 'tagline');
    $comment = filter_input(INPUT_POST, 'comment');

    updateLinksSettings($tagline, $comment);

    redirect('link/index');
}

function addAction()
{
    checkLogin();

    $title      = filter_input(INPUT_POST, 'title');
    $tagline    = filter_input(INPUT_POST, 'tagline');
    $uri        = filter_input(INPUT_POST, 'uri');
    $text       = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');

    addLink($title, $tagline, $text, $uri, $visibility);

    redirect('link/index');
}

function delAction(array $params)
{
    checkLogin();

    $id = filter_var($params['1']);

    setContentsFlagById($id, 'trash');

    redirect('link/index');
}

function updateAction()
{
    checkLogin();

    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');
    $uri     = filter_input(INPUT_POST, 'uri');
    $comment = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');

    updateLink($id, $title, $comment, $uri, $visibility);

    redirect('link/index');
}
