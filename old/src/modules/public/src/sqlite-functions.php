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
        substr(`text`, 0, 2000) as text,
        (SELECT (`firstname` || ' ' || `lastname`) as author
            FROM `users`
            WHERE `users`.`id` = `contents`.`author_id`) as author,
        strftime('%s', `created_at`) AS datetime,
        length(`text`) AS charCount
        FROM `contents`
        WHERE `content_type` = 'article'
            AND `flag` != 'trash'
            AND `visibility` = 'true'
            ORDER BY `datetime` DESC
            LIMIT 1
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return $result;
        }

        return array();
    } catch (PDOException $ex) {
        $ex->getMessage();
        exit();
    }
}

/**
 *
 * @return PDOStatement
 *
 * @since 0.8.0
 */
function getPublicArticles(): array
{
    $sql = "
    SELECT `id`,
        `title`,
        substr(`text`, 0, 1000) as text,
        (SELECT (`firstname` || ' ' || `lastname`) as author
            FROM `users`
            WHERE `users`.`id` = `contents`.`author_id`) as author,
        strftime('%s', `created_at`) AS datetime
        FROM `contents`
        WHERE `content_type` = 'article'
            AND `visibility` = 'true'
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
        (SELECT (`firstname` || ' ' || `lastname`) as author
            FROM `users`
            WHERE `users`.`id` = `contents`.`author_id`) as author,
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
 *
 * @return array
 *
 * @since 0.9.0
 */
function getPublicDownloads(): array
{
    $sql = "
    SELECT `title`,
        `text`,
        `path`,
        `filename`,
        strftime('%s', created_at) AS datetime,
        `tagline`,
        `text`
        FROM `contents`
            WHERE `content_type` = 'download'
                AND `visibility` = 'true'
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
 *
 * @return array
 */
function getInfobox(): array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `title`,
        `text`
        FROM `contents`
        WHERE `content_type` = 'mainpage'
            AND `flag` = 'infobox'
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
