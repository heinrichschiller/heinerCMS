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
    $templateList = [];
    
    $pageList = getAllPages();
    
    if(count($pageList) > 0 ) {
        $template = 'pages.phtml';
    } else {
        $template = 'no_pages.phtml';
    }
    
    $templateList[] = $template;
    
    return render($templateList, array('pages' => $pageList));
}

function newAction()
{
    $templateList = [
        'new_page.phtml'
    ];
    
    return render($templateList);
}

function addAction()
{
    $title      = filter_input(INPUT_POST, 'title');
    $tagline    = filter_input(INPUT_POST, 'tagline');
    $text       = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');
    
    addPage($title, $tagline, $text, $visibility);
    
    redirectToPage();
}

function delAction()
{
    $id = filter_input(INPUT_POST, 'id');
    
    setContentsFlagById($id, 'trash');
    
    redirectToPage();
}

function updateAction()
{
    $id      = filter_input(INPUT_POST, 'id');
    $title   = filter_input(INPUT_POST, 'title');
    $tagline = filter_input(INPUT_POST, 'tagline');
    $text = filter_input(INPUT_POST, 'text');
    $visibility = filter_input(INPUT_POST, 'visibility');
    
    updatePage($id, $title, $tagline, $text, $visibility);
    
    redirectToPage();
}

function redirectToPage()
{
    header ( 'Location: /../page/index' );
}