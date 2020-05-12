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
 * Get all page entries from contents-table, where page flag
 * is not marked as 'trash'.
 *
 * @return array
 */
function getAllPages(): array
{
    $pdo = getPdoConnection();
    $result = [];

    $sql = "
    SELECT `id`,
        `title`,
        strftime('%s', `created_at`) AS datetime,
        `visibility`
        FROM `contents`
        WHERE `content_type` = 'page'
            AND `flag` = ''
            ORDER BY `created_at` DESC
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
 * Get a page entry from table 'contents' by id.
 *
 * @param int $id
 * @return array
 *
 * @since 0.8.0
 */
function getPage(int $id) : array
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`,
        `title`,
        `tagline`,
        `text`,
        strftime('%s', `created_at`) AS datetime,
        `visibility`
        FROM `contents`
        WHERE `content_type`= 'page'
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
 * Add a page entry into `contents` table.
 *
 * @param string $title      - Title of the page.
 * @param string $tagline    - Tagline of the page.
 * @param string $text       - Text of the page.
 * @param string $visibility -
 *
 * @since 0.8.0
 */
function addPage(string $title,
    string $tagline,
    string $text,
    string $visibility)
{
    $sql = "
    INSERT INTO `contents` (
        `title`,
        `tagline`,
        `text`,
        `content_type`,
        `visibility`,
        `flag`
        )
        VALUES (
            :title,
            :tagline,
            :text,
            :content_type,
            :visibility,
            :flag
        )
    ";

    $pdo = getPdoConnection();

    try {
        $content_type = 'page';
        $flag = '';

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':content_type', $content_type);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':flag', $flag);

        $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }

}

/**
 * Update page entry.
 *
 * @param int $id
 * @param string $title
 * @param string $text
 * @param string $visibility
 *
 * @since 0.8.0
 */
function updatePage(int $id,
    string $title,
    string $tagline,
    string $text,
    string $visibility)
{
    $pdo = getPdoConnection();

    $sql = "
    UPDATE `contents`
        SET `title` = :title,
            `tagline` = :tagline,
            `text` = :text,
            `visibility` = :visibility
            WHERE `content_type` = 'page'
                AND `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':tagline', $tagline);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':visibility', $visibility);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}
