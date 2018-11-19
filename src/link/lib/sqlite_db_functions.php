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
 * Get all link entries from contents-table, where link flag
 * is not marked as 'trash'.
 * 
 * @return array
 * 
 * @since 0.9.0
 */
function getAllLinks(): array
{
    $pdo = getPdoConnection();
    $result = [];
    
    $sql = "
    SELECT `id`,
        `title`,
        `uri`,
        strftime('%s', `created_at`) AS datetime,
        `visibility`
        FROM `contents`
        WHERE `content_type` = 'link'
            AND `flag` = ''
            ORDER BY `title` DESC
    ";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        while($row = $stmt->fetch((PDO::FETCH_ASSOC))) {
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
 * Get a link entry from table 'contents' by id.
 *
 * @param int $id - Id of a link entry.
 * @return array  - List of a link entry.
 *
 * @since 0.8.0
 */
function getLinkById(int $id)
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `id`,
        `title`,
        `tagline`,
        `uri`,
        `text`,
        strftime('%s', `created_at`) AS datetime,
        `visibility`
        FROM `contents`
        WHERE `content_type` = 'link'
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

function getLinksSettings() : array
{
    $pdo = getPdoConnection();
    
    $sql = "
    SELECT `tagline`,
        `text`
        FROM `contents_settings`
        WHERE `content_type` = 'link'
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
 *
 * @return array
 *
 * @since 0.9.0
 */
function getPublicLinks(): array
{
    $sql = "
    SELECT `title`,
        `tagline`,
        `uri`,
        `text`,
        strftime('%s', `created_at`) AS datetime
        FROM `contents`
        WHERE `content_type` = 'link'
            AND `visibility` != 'false'
            AND `flag` != 'trash'
            ORDER BY `datetime` DESC
    ";
    
    $pdo = getPdoConnection();
    $result = [];
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        
        return $result;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
    
}

/**
 * Add link entry.
 *
 * @param string $title
 * @param string $tagline
 * @param string $text
 * @param string $uri
 * @param string $visibility
 *
 * @since 0.8.0
 */
function addLink(string $title,
    string $tagline,
    string $text,
    string $uri,
    string $visibility)
{
    $content_type = 'link';
    $flag = '';
    
    $sql = "
    INSERT INTO `contents` (
        `title`,
        `tagline`,
        `uri`,
        `text`,
        `content_type`,
        `visibility`,
        `flag`
        )
        VALUES (
            :title,
            :tagline,
            :uri,
            :text,
            :content_type,
            :visibility,
            :flag
        )";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);
        
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Update a link entry.
 *
 * @param int $id
 * @param string $title
 * @param string $text
 * @param string $uri
 * @param string $visibility
 *
 * @since 0.8.0
 */
function updateLink(int $id,
    string $title,
    string $text,
    string $uri,
    string $visibility)
{
    $sql = "
    UPDATE `contents`
        SET `title` = :title,
        `text` = :text,
        `uri` = :uri,
        `visibility` = :visibility
        WHERE `content_type` = 'link'
            AND `id` = :id
    ";
    
    $pdo = getPdoConnection();
    
    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':uri', $uri);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    } catch(PDOException $ex) {
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
function updateLinksSettings(string $tagline, string $text)
{
    $sql = "
    UPDATE `contents_settings`
        SET `tagline`= :tagline,
        `text`= :text
        WHERE `content_type`= 'link'
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