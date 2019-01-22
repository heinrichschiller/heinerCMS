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
    $settings = getGeneralSettings();
    $article  = getCurrentArticle();
    $info     = getInfobox();

    $templateList = [
        'mainpage.phtml'
    ];

    $list = [
        'settings' => $settings,
        'article'  => $article,
        'info'     => $info
    ];

    return render($templateList, $list);
}

function articleAction(array $params): string
{
    $articleItems = getArticleDetailed($params[1]);

    $templateList = [
        'article.phtml'
    ];

    return render($templateList, array('article' => $articleItems));
}

function articlesAction(): string
{
    include MODULES_PATH . 'article/lib/' . DB_DRIVER . '-functions.php';

    $templateList = [
        'articles.phtml'
    ];

    $articlesList = getPublicArticles();
    $settingsItems = getArticleSettings();

    $itemsList = [
        'articles' => $articlesList,
        'settings' => $settingsItems
    ];

    return render($templateList, $itemsList);
}

function downloadAction(int $id): string
{
    $templateList = [
        'download.phtml'
    ];

    return render($templateList);
}

function downloadsAction(): string
{
    include MODULES_PATH . 'download/lib/' . DB_DRIVER . '-functions.php';

    $templateList = [
        'downloads.phtml'
    ];

    $downloadItems = getPublicDownloads();
    $settingsItems = getDownloadSettings();

    $itemsList = [
        'downloads' => $downloadItems,
        'settings'  => $settingsItems
    ];

    return render($templateList, $itemsList);
}

function linkAction(int $id): string
{
    $templateList = [
        'link.phtml'
    ];

    return render($templateList);
}

function linksAction(): string
{
    include MODULES_PATH . 'link/lib/' . DB_DRIVER . '-functions.php';

    $templateList = [
        'links.phtml'
    ];

    $linkItems = getPublicLinks();
    $settingsItems = getLinksSettings();

    $itemsList = [
        'links'    => $linkItems,
        'settings' => $settingsItems
    ];

    return render($templateList, $itemsList);
}
