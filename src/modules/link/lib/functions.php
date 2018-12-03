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

function indexAction(): string
{
    checkLogin();

    $templateList = [];

    $linkList = getAllLinks();

    if(count($linkList) > 0) {
        $template = 'links.phtml';
    } else {
        $template = 'no_links.phtml';
    }

    $templateList[] = $template;

    return render($templateList, array('links' => $linkList));
}

function editAction(array $params): string
{
    checkLogin();

    $linkItems = getLinkById($params['1']);

    $templateList = [
        'edit_link.phtml'
    ];

    return render($templateList, array('link' => $linkItems));
}

function newAction(): string
{
    checkLogin();

    $templateList = [
        'new_link.phtml'
    ];

    return render($templateList);
}

function settingsAction(): string
{
    checkLogin();

    $templateList = [
        'link-settings.phtml'
    ];

    return render($templateList);
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

    redirectToLink();
}

function delAction(array $params)
{
    checkLogin();

    $id = filter_var($params['1']);

    setContentsFlagById($id, 'trash');

    redirectToLink();
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

    redirectToLink();
}

function redirectToLink()
{
    header('Location: /../link/index');
}
