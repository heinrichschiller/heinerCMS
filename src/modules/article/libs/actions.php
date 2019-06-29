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
 * @filesource /src/modules/article/actions.php
 */
function indexAction(): string
{
    checkLogin();

    $articleList = getAllArticles();

    $templateList = [
        'articles.phtml'
    ];

    return render($templateList, ['articles' => $articleList]);
}

/**
 * @filesource /src/modules/article/actions.php
 */
function newAction(): string
{
    checkLogin();

    $templateList = [
        'article.phtml'
    ];

    return render($templateList);
}

/**
 * @filesource /src/modules/article/actions.php
 */
function editAction(array $params): string
{
    checkLogin();

    $articleList = getArticle($params[1]);

    $templateList = [
        'article.phtml'
    ];

    return render($templateList, ['article' => $articleList]);
}

/**
 * @filesource /src/modules/article/actions.php
 */
function settingsAction(): string
{
    checkLogin();

    $settings = getArticleSettings();

    $templateList = [
        'article_settings.phtml'
    ];

    return render($templateList, ['settings' => $settings]);
}

/**
 * @filesource /src/modules/article/actions.php
 */
function updatesettingsAction()
{
    checkLogin();

    $tagline = filter_input(INPUT_POST, 'tagline');
    $comment = filter_input(INPUT_POST, 'comment');

    updateArticleSettings($tagline, $comment);

    redirectToArticleSettings();
}

/**
 * @filesource /src/modules/article/actions.php
 */
function addAction()
{
    checkLogin();

    if(isPost()) {
        $title      = filter_input(INPUT_POST, 'title');
        $content    = filter_input(INPUT_POST, 'text');
        $visibility = filter_input(INPUT_POST, 'visibility');
        $userId     = $_SESSION['id'];

        addArticle($title, $content, $visibility, $userId);
    }

    redirectToArticle();
}

/**
 * @filesource /src/modules/article/actions.php
 */
function delAction(array $params)
{
    checkLogin();

    $id = filter_var($params[1]);

    setContentsFlagById($id, 'trash');

    redirectToArticle();
}

/**
 * @filesource /src/modules/article/actions.php
 */
function updateAction()
{
    checkLogin();

    $id         = filter_input(INPUT_POST, 'id');
    $title      = filter_input(INPUT_POST, 'title');
    $content    = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');
    $userId     = $_SESSION['id'];

    updateArticle($id, $title, $content, $userId, $visibility);

    redirectToArticle();
}
