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
 * Get all downloads entries from contents-table, where downloads flag
 * is not marked as 'trash'.
 *
 * @return array
 *
 * @since 0.9.0
 */
function getAllDownloads(): array
 {
     $pdo = getPdoConnection();

     $sql = "
     SELECT `id`,
         `title`,
         UNIX_TIMESTAMP(`created_at`) AS datetime,
         `path`,
         `filename`,
         `visibility`
         FROM `contents`
         WHERE `content_type` = 'download'
             AND `flag` = ''
             ORDER BY `created_at` DESC
     ";

     try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $result = [];

        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        if($result) {
            return $result;
        }

        return array();
     } catch (PDOException $ex) {
         echo $ex->getMessage();
         exit();
     }
 }

 /**
  * Get a download entry from table 'downloads' by id.
  *
  * @param int $id - Id of a download entry.
  * @return array  - List of a download entry.
  *
  * @since 0.8.0
  */
 function getDownload(int $id) : array
 {
     $pdo = getPdoConnection();

     $sql = "
     SELECT `id`,
         `title`,
         `text`,
         `path`,
         `filename`,
         UNIX_TIMESTAMP(`created_at`) AS datetime,
         `visibility`
         FROM `contents`
         WHERE `content_type` = 'download'
             AND `id`= :id
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
  * @return array
  *
  * @since 0.8.0
  */
 function getDownloadSettings() : array
 {
     $pdo = getPdoConnection();

     $sql = "
     SELECT `tagline`,
         `text`
         FROM `contents_settings`
         WHERE `content_type` = 'download';
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
  * Add a download entry to contents table.
  *
  * @param string $title         - Title of a download.
  * @param string $text          - Text of a download.
  * @param string $path          - Path of a download.
  * @param string $filename      - Filename of a download.
  * @param string $visibility    - Is a download visible or not.
  *
  * @since 0.8.0
  */
 function addDownload(string $title,
     string $text,
     string $path,
     string $filename,
     string $visibility)
 {
     $sql = "
     INSERT INTO `contents` (
         `title`,
         `text`,
         `content_type`,
         `path`,
         `filename`,
         `visibility`
         )
         VALUES (
             :title,
             :text,
             :content_type,
             :path,
             :filename,
             :visibility
         )
     ";

     $pdo = getPdoConnection();

     try {
         $contentType = 'download';

         $stmt = $pdo->prepare($sql);

         $stmt->bindParam(':title', $title);
         $stmt->bindParam(':text', $text);
         $stmt->bindParam(':content_type', $contentType);
         $stmt->bindParam(':path', $path);
         $stmt->bindParam(':filename', $filename);
         $stmt->bindParam(':visibility', $visibility);

         $stmt->execute();
     } catch (PDOException $ex) {
         echo $ex->getMessage();
         exit();
     }
 }

 /**
  * Update a download entry.
  *
  * @param string $title
  * @param string $text
  * @param string $path
  * @param string $filename
  * @param string $visibility
  *
  * @since 0.8.0
  */
 function updateDownload(int $id,
     string $title,
     string $text,
     string $path,
     string $filename,
     string $visibility)
 {
     $pdo = getPdoConnection();

     $sql = "
     UPDATE `contents`
         SET `title` = :title,
             `text` = :text,
             `path` = :path,
             `filename` = :filename,
             `visibility` = :visibility
             WHERE `content_type` = 'download'
                 AND `id` = :id
     ";

     try {
         $stmt = $pdo->prepare($sql);

         $stmt->bindParam(':title', $title);
         $stmt->bindParam(':text', $text);
         $stmt->bindParam(':path', $path);
         $stmt->bindParam(':filename', $filename);
         $stmt->bindParam(':visibility', $visibility);
         $stmt->bindParam(':id', $id);

         $stmt->execute();
     } catch (PDOException $ex) {
         echo $ex->getMessage();
         exit();
     }
 }

 /**
  *
  * @param string $tagline
  * @param string $text
  *
  * @since 0.8.0
  */
 function updateDownloadsSettings(string $tagline, string $text)
 {
     $sql = "
     UPDATE `contents_settings`
         SET `tagline`= :tagline,
         `text`= :text
         WHERE `content_type`= 'download'
     ";

     $pdo = getPdoConnection();

     try {
         $stmt = $pdo->prepare($sql);

         $stmt->bindParam(':tagline', $tagline);
         $stmt->bindParam(':text', $text);

         $stmt->execute();
     } catch (Exception $ex) {
         echo $ex->getMessage();
         exit();
     }
 }
