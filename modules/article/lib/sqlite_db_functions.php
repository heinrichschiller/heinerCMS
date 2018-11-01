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

/**
 * Get all article entries from contents-table, where articles flag
 * is not marked as 'trash'.
 * 
 * @return array
 */
function getAllArticles(): array
{
    $pdo = getPdoConnection();
    $result = [];

    $sql = "
    SELECT `id`, 
        `title`, 
        strftime('%s', `created_at`) AS datetime, 
        `visibility`
        FROM `contents` 
        WHERE `content_type`= 'article'
            AND `flag` = '' 
            ORDER BY `created_at` DESC
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
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
        strftime('%s', `created_at`) AS datetime 
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
 * Add a new article in 'articles' table.
 * 
 * @param string $title      - Title of an article.
 * @param string $text       - Text of an article.
 * @param string $visibility - Is an article visible or not.
 * 
 * @since 0.8.0
 */
function addArticle(string $title, string $text, string $visibility)
{
    $contentType = 'article';
    $flag = '';
    
    $sql = "
    INSERT INTO `contents` (
        `title`, 
        `text`, 
        `content_type`,
        `visibility`,
        `flag`
        ) 
        VALUES (
            :title, 
            :text, 
            :content_type,
            :visibility,
            :flag
        )
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $contentType);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);
        
        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update a article in 'articles' table by id.
 * 
 * @param int $id            - Id of an article.
 * @param string $title      - Title of an article.
 * @param string $text       - Text of an article.
 * @param string $visibility - Is article visible or not.
 * 
 * @since 0.8.0
 */
function updateArticle(int $id,
    string $title,
    string $text,
    string $visibility)
{
    $pdo = getPdoConnection();
    
    $sql = "
    UPDATE `contents` 
        SET `title` = :title, 
        `text` = :text, 
        `visibility` = :visibility 
        WHERE `id` = :id
    ";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
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
function updateArticleSettings(string $tagline, string $text)
{
    $sql = "
    UPDATE `contents_settings` 
        SET `tagline`= :tagline,
        `text`= :text 
        WHERE `content_type`= 'article'
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

/**
 * 
 * @return PDOStatement
 * 
 * @since 0.8.0
 */
function loadPublicArticlesStatement() : PDOStatement
{
    $sql = "
    SELECT `id`, 
        `title`, 
        `text` as text, 
        strftime('%s', `created_at`) AS datetime 
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
 * Get an article entry from 'articles' table by id.
 * 
 * @param int $id - Id from an article entry.
 * @return array  - Article list from an entry.
 * 
 * @since 0.8.0
 */
function getArticle(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`, 
        `title`, 
        `text`, 
        strftime('%s', `created_at`) AS datetime, 
        `visibility` 
        FROM `contents` 
        WHERE `id` = :id 
            AND `flag` != 'trash'
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
        strftime('%s', `created_at`) AS datetime
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

function getArticleSettings() : array
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `tagline`,
        `text`
        FROM `contents_settings`
        WHERE `content_type` = 'article'
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
