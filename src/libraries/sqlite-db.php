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

function normalize(int $id, string $table)
{
    $sql = "
    SELECT COUNT(`id`)
    FROM `$table`
    ";

    if ($id <= 0 && $id > count($result)) {
        // @todo: entry not found
    }

    return $id;
}

function updateMainpage($title, $text)
{
    $pdo = getPdoConnection();

    $sql="
    UPDATE `contents`
        SET `title` = :title,
            `text` = :text
            WHERE `content_type` = 'mainpage'
                AND `flag` = 'infobox'
    ";

    try {
        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':text', $text);

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Get a list from 'settings' table.
 *
 * @return array - List of settings entries.
 *
 * @since 0.4.0
 */
function getGeneralSettings() : array
{
    $sql = "
    SELECT `title`,
        `tagline`,
        `theme`,
        `darkmode`,
        `blog_url`,
        `lang_short`,
        `footer`
        FROM `settings`
        WHERE 1
    ";

    $pdo = getPdoConnection();

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
 * Delete a content entry from contents-table by id.
 *
 * @param int $id - Id of an item.
 *
 * @since 0.8.0
 */
function deleteItemById(int $id)
{
    $pdo = getPdoConnection();

    $sql = "
    DELETE FROM `contents`
    WHERE `id` = :id
        AND `flag`= 'trash'
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 *
 * @param string $table
 */
function deleteAllTrashItems(string $table)
{
    $pdo = getPdoConnection();

    $sql = "
    DELETE FROM `:table`
    WHERE `trash` = 'true'
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 *
 * @param int $id
 * @param string $flag
 *
 * @since 0.8.0
 */
function setContentsFlagById(int $id, string $flag)
{
    $pdo = getPdoConnection();

    $sql = "
    UPDATE `contents`
        SET `flag`=:flag
        WHERE `id`= :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':flag', $flag);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Get a title of a content by id.
 *
 * @param int $id - Id of a content title.
 *
 * @return string
 */
function getContentsTitleById(int $id)
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `title`
        FROM `contents`
        WHERE `id` = :id
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 *
 * @param string $type
 * @return int
 */
function countContentType(string $type): int
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT COUNT(`id`)
        FROM `contents`
        WHERE `content_type` = '$type'
            AND `flag` != 'trash'
            AND `visibility` = 'true'
    ";

    foreach ($pdo->query($sql) as $row) {
        $number = (int) $row[0];
    }

    return $number;
}

/**
 * Count all Entries for navigation information
 *
 * @return array
 *
 * @since 0.8.0
 */
function countEntries()
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'article' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'download' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'link' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(`id`) FROM `contents` WHERE `content_type` = 'page' AND `flag` != 'trash'
        UNION ALL
        SELECT COUNT(*) as result
            FROM `contents`
            WHERE `flag` = 'trash'
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }

}

/**
 *
 * @param string $db
 * @param int $count
 * @deprecated
 *
 * @return array
 */
function loadFromTable(string $table, int $count)
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT `id`,
        `title`,
        UNIX_TIMESTAMP(`created_at`) AS datetime,
        `visibility`
        FROM `$table`
        WHERE `trash` = 'false'
            ORDER BY `created_at`
            DESC LIMIT $count
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}

/**
 * Get the full name of the current user who is logged in.
 *
 * @return string - Full name of the user.
 *
 * @since 0.12.0
 */
function getCurrentAuthor()
{
    $pdo = getPdoConnection();

    $sql = "
    SELECT (`firstname` || ' ' || `lastname`) as author
        FROM `users`
        WHERE `id` = :id
";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        exit();
    }
}
