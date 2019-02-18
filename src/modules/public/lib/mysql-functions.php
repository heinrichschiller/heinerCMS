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
 * Get an actualy article entry from 'contents' table.
 *
 * @return array  - Article list from an entry.
 *
 * @since 0.8.0
 */
function getCurrentArticle() : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`,
        `title`,
        `text`,
        UNIX_TIMESTAMP(`contents`.`created_at`) AS datetime
        FROM `contents`
        WHERE `content_type` = 'article'
            AND `flag` != 'trash'
            ORDER BY `datetime` DESC
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Get a list if items from an article by id.
 *
 * @param int $id - Id of an article.
 * @return array  -
 *
 * @since 0.8.0
 */
function getArticleDetailed(int $id) : array
{
    $sql = "
    SELECT `id`,
        `title`,
        `text` as text,
        UNIX_TIMESTAMP(`created_at`) AS datetime
        FROM `contents`
        WHERE `content_type` = 'article'
            AND `visibility` = 'true'
            AND `flag` != 'trash'
            ORDER BY `datetime` DESC
    ";

    $pdo = getPdoConnection();

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
         echo $ex->getMessage();
         exit();
    }
}

/**
 * Get a list if items from an article by id.
 *
 * @param int $id - Id of an article.
 * @return array  -
 *
 * @since 0.8.0
 */
function getArticleDetailed(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `title`,
        `text`,
        UNIX_TIMESTAMP(`created_at`) AS datetime
        FROM `contents`
        WHERE `content_type` = 'article'
            AND `visibility` = 'true'
            AND `flag` != 'trash'
            AND `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 *
 * @return PDOStatement
 *
 * @since 0.8.0
 */
function loadPublicDownloadsStatement() : PDOStatement
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `contents`.`title`,
        `contents`.`text`,
        `contents`.`path`,
        `contents`.`filename`,
        UNIX_TIMESTAMP(`contents`.`created_at`) AS datetime,
        `contents_settings`.`tagline` as downloads_tagline,
        `contents_settings`.`text` as downloads_text
        FROM `contents`,
            `contents_settings`
            WHERE `contents`.`content_type` = 'download'
                AND `contents_settings`.`content_type` = 'download'
                AND `visibility` = 'true'
                AND `flag` != 'trash'
                ORDER BY `datetime` DESC
    ";
 
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

 /**
  *
  * @return PDOStatement
  *
  * @since 0.8.0
  */
  function loadPublicLinksStatement() : PDOStatement
  {
      $pdo = getPdoConnection();
 
      $sql = "
      SELECT contents.title,
          contents.tagline,
          contents.uri,
          contents.text,
          UNIX_TIMESTAMP(contents.created_at) AS datetime,
          contents_settings.tagline as settings_tagline,
          contents_settings.text as settings_comment
          FROM `contents`,
              `contents_settings`
          WHERE `contents`.`content_type` = 'link'
              AND `contents_settings`.`content_type` = 'link'
              AND `visibility` = 'true'
              AND `flag` != 'trash'
              ORDER BY `datetime` DESC
      ";
 
      try {
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
 
          return $stmt;
      } catch (PDOException $ex) {
          echo $ex->getMessage();
          exit();
      }
  }