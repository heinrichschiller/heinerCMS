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

function indexAction()
{
    $templateList = [
        'navigation.phtml'
    ];
    
    $articleList = getAllArticles();
    
    if (count($articleList) > 0 ) {
        $template = 'articles.phtml';
    } else {
        $template = 'no_articles.phtml';
    }

    $templateList[] = $template;
    
    return render($templateList, array('articles' => $articleList));
}

function newAction()
{
    $templateList = [
        'navigation.phtml',
        'new_article.phtml'
    ];
    
    return render($templateList);
}

function addAction()
{
    $title      = filter_input(INPUT_POST, 'title');
    $content    = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');
    
    addArticle($title, $content, $visibility);
    
    header("Location: /../article/index");
}

