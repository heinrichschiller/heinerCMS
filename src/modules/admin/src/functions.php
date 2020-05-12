<?php

/**
 * If you are reading this in your web browser, your server is probably
 * not configured correctly to run PHP applications!
 *
 * MIT License
 *
 * Copyright (c) 2017 - 2020 Heinrich Schiller
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
 * Loading a string of theme options.
 *
 * @return string
 */
function load_theme_options(): string
{
     $html = '';

     $template_dir = __DIR__ . '/../templates/';

     $files = scandir($template_dir);

     for ($i = 2; $i <= count($files) - 1; $i ++) {
        if ($files[$i] === $_SESSION['theme']) {
            $select = ' selected';
        } else {
            $select = '';
        }

        $html .= "<option $select>$files[$i]</option>";
    }

    return $html;
}

/**
 * Get a list of all locales in data/locales directory
 *
 * @return array
 *
 * @since 0.9.0
 */
function getLocales() : array
{
    $localesPath = ROOT_PATH . 'src/locales/';
    $files = scandir($localesPath);

    $xmlItem  = [];
    $xmlItems = [];

    for ($i = 2; $i <= count($files) -1; $i++) {
        $xmlFile = $localesPath . $files[$i];

        $xmlContents = file_get_contents($xmlFile);
        $xmlString = simplexml_load_string($xmlContents);

        $xmlItem = [
            'short' => (string) $xmlString->attributes()->short,
            'lang'  => (string) $xmlString->attributes()->lang
        ];

        $xmlItems[] = $xmlItem;
    }

    return $xmlItems;
}
