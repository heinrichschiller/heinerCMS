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
  * Update settings-table.
  *
  * @param string $title
  * @param string $tagline
  * @param string $theme
  * @param string $blogUrl
  * @param string $language
  * @param string $footer
  *
  * @since 0.8.0
  */
 function updateGeneralSettings(string $title,
     string $tagline,
     string $theme,
     string $darkmode,
     string $blogUrl,
     string $language,
     string $footer)
 {
     $sql = '
     UPDATE `settings`
         SET `title`=:title,
             `tagline`=:tagline,
             `theme`=:theme,
             `darkmode`=:darkmode,
             `blog_url`=:blog_url,
             `lang_short`=:language,
             `footer`=:footer
             WHERE 1
     ';

     $pdo = getPdoConnection();

     try {
         $stmt = $pdo->prepare($sql);

         $stmt->bindParam(':title', $title);
         $stmt->bindParam(':tagline', $tagline);
         $stmt->bindParam(':theme', $theme);
         $stmt->bindParam(':darkmode', $darkmode);
         $stmt->bindParam(':blog_url', $blogUrl);
         $stmt->bindParam(':language', $language);
         $stmt->bindParam(':footer', $footer);

         $stmt->execute();
     } catch (Exception $ex) {
         echo $ex->getMessage();
         exit();
     }
 }
