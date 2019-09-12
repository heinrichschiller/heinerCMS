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

function filterSanitizeInt(int $iNum): int
{
    return filter_var($iNum, FILTER_SANITIZE_NUMBER_INT);
}

function filterValidateInt(int $iNum): int
{
    return filter_var($iNum, FILTER_VALIDATE_INT);
}

function filterSanitizeFloat(float $fNum): float
{
    return filter_var($fNum, FILTER_SANITIZE_NUMBER_FLOAT);
}

function filterValidateFloat(float $fNum): float
{
    return filter_var($fNum, FILTER_VALIDATE_FLOAT);
}

function filterSanitizeEmail(string $email): string
{
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

function filterValidateEmail(string $email): string
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function filterSanitizeUrl(string $url): string
{
    return filter_var($url, FILTER_SANITIZE_URL);
}

function filterValidateUrl(string $url): string
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Strip a HTML and PHP tags from a string and convert convert special characters
 * to HTML entities.
 *
 * @param string $data
 * @param string $encoding
 *
 * @return string - Clean string.
 *
 * @since 0.10.0
 */
function escapeString(string $data, string $encoding = 'UTF-8'): string
{
    return htmlspecialchars(strip_tag($data), ENT_QUOTES | ENT_HTML5, $encoding);
}
