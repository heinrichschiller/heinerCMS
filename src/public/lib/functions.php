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
    include ARTICLE_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
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
    include ARTICLE_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
    $articleItems = getArticleDetailed($params[1]);

    $templateList = [
        'article.phtml'
    ];
    
    return render($templateList, array('article' => $articleItems));
}

function articlesAction(): string
{
    include ARTICLE_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
    $templateList = [
        'articles.phtml'
    ];
    
    $articlesList = getPublicArticles();
    
    return render($templateList, array('articles' => $articlesList));
}

function downloadAction(int $id): string
{
    include DOWNLOAD_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
    $templateList = [
        'download.phtml'
    ];
    
    return render($templateList);
}

function downloadsAction(): string
{
    include DOWNLOAD_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
    $templateList = [
        'downloads.phtml'
    ];
    
    return render($templateList);
}

function linkAction(int $id): string
{
    include LINK_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
    $templateList = [
        'link.phtml'
    ];
    
    return render($templateList);
}

function linksAction(): string
{
    include LINK_LIB_PATH . DB_DRIVER . '_db_functions.php';
    
    $templateList = [
        'links.phtml'
    ];
    
    return render($templateList);
}