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

    $articleList = getAllArticles();

    if (count($articleList) > 0 ) {
        $template = 'articles.phtml';
    } else {
        $template = 'no_articles.phtml';
    }

    $templateList[] = $template;

    return render($templateList, array('articles' => $articleList));
}

function newAction(): string
{
    checkLogin();

    $templateList = [
        'new_article.phtml'
    ];

    return render($templateList);
}

function editAction(array $params): string
{
    checkLogin();

    $articleList = getArticle($params[1]);

    $templateList = [
        'edit_article.phtml'
    ];

    return render($templateList, array('article' => $articleList));
}

function settingsAction(): string
{
    checkLogin();

    $settings = getArticleSettings();

    $templateList = [
        'article_settings.phtml'
    ];

    return render($templateList, array('settings' => $settings));
}

function updatesettingsAction()
{
    checkLogin();

    $tagline = filter_input(INPUT_POST, 'tagline');
    $comment = filter_input(INPUT_POST, 'comment');

    updateArticleSettings($tagline, $comment);

    redirectToArticleSettings();
}

function addAction()
{
    checkLogin();

    $title      = filter_input(INPUT_POST, 'title');
    $content    = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');

    addArticle($title, $content, $visibility);

    redirectToArticle();
}

function delAction(array $params)
{
    checkLogin();

    $id = filter_var($params[1]);

    setContentsFlagById($id, 'trash');

    redirectToArticle();
}

function updateAction()
{
    checkLogin();

    $id         = filter_input(INPUT_POST, 'id');
    $title      = filter_input(INPUT_POST, 'title');
    $content    = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');

    updateArticle($id, $title, $content, $visibility);

    redirectToArticle();
}

function redirectToArticle()
{
    header("Location: /../article/index");
}

function redirectToArticleSettings()
{
    header ( 'Location: index.php?uri=articlessettings' );
}
