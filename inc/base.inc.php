<?php

/* Konfigurationsvariablen */
$base['title'] = 'Heinrich-Schiller.de';
$base['navigation'] = '<li><a href="http://heinrich-schiller.de/wordpress/" target="blank">Blog</a></li>
    <li><a href="$PHP_SELF?uri=news">News</a></li>
    <li><a href="$PHP_SELF?uri=downloads">Downloads</a></li>
    <li><a href="$PHP_SELF?uri=links">Links</a></li>
    <li><a href="$PHP_SELF?uri=articles">Artikel</a></li>';
$base['content'] = '';
$base['template'] = 'templates/bootstrap-3.3.7/pub_template.tpl.php';

$base['adm_title'] = 'heinerCMS';
$base['adm_navigation'] = '<div class="list-group">
    <a href="$PHP_SELF?uri=dashboard" class="list-group-item">
        <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard
    </a>
    </div>
    <div class="list-group">
    <li class="list-group-item active">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Content
    </li>
    <a href="$PHP_SELF?uri=news" class="list-group-item">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> News
        <span class="badge">0</span>
    </a>
    <a href="$PHP_SELF?uri=downloads" class="list-group-item">
        <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Downloads
        <span class="badge">0</span>
    </a>
    <a href="$PHP_SELF?uri=links" class="list-group-item">
        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Links
        <span class="badge">0</span>
    </a>
    <a href="$PHP_SELF?uri=articles" class="list-group-item">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Articles
        <span class="badge">0</span>
    </a>
    </div>
    <div class="list-group">
        <li class="list-group-item active">
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Settings
        </li>
        <a href="$PHP_SELF?uri=general" class="list-group-item">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> General
        </a>
        <a href="$PHP_SELF?uri=user" class="list-group-item">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> User
        </a>
    </div>';
$base['adm_content'] = '';
$base['adm_actual'] = 'Sie sind hier: ';

// config.ini for heinercms
$config_ini = __DIR__ . '/../source/configs/config.ini';

// temporary "language packs" for heinercms
$arr_language_de = [
    '{yes}' => 'ja',
    '{no}'  => 'nein',
    '{new}' => 'neu',
    '{firstname}' => 'Vorname',
    '{lastname}' => 'Nachname',
    '{username}' => 'Benutzername',
    '{email}' => 'Email',
    '{show as public}' => 'Öffentlich anzeigen als',
    '{password}' => 'Passwort',
    '{repeat password}' => 'Passwort wiederholen',
    '{save}' => 'Speichern',
    '{reset}' => 'Zurücksetzen',
    '{visible}' => 'Sichtbar',
    '{dashboard}' => 'Dashboard',
    '{content}' => 'Inhalt',
    '{news}' => 'Neuigkeiten',
    '{downloads}' => 'Downloads',
    '{links}' => 'Links',
    '{articles}' => 'Artikel',
    '{article}' => 'Artikel',
    '{settings}' => 'Einstellungen',
    '{general}' => 'Allgemein',
    '{user}' => 'Benutzer',
    '{trash}' => 'Mülleimer',
    '{new user}' => 'Neuer Benutzer',
    '{create}' => 'Erstellen',
    '{create news}' => 'Neuigkeit erstellen',
    '{create download}' => 'Download erstellen',
    '{create link}' => 'Link erstellen',
    '{create article}' => 'Artikel erstellen',
    '{date}' => 'Datum',
    '{title}' => 'Titel',
    '{actions}' => 'Aktionen',
    '{clear selection}' => 'Auswahl löschen',
    '{clear all}' => 'Alle löschen',
    '{administration}' => 'Administration',
    '{german}' => 'Deutsch',
    '{english}' => 'Englisch',
    '{russian}' => 'Russisch'
];

$arr_language_en = [
    '{yes}' => 'yes',
    '{no}'  => 'no',
    '{new}' => 'new',
    '{firstname}' => 'Firstname',
    '{lastname}' => 'Lastname',
    '{username}' => 'Username',
    '{email}' => 'Email',
    '{show as public}' => 'Show as public',
    '{password}' => 'Password',
    '{repeat password}' => 'Repeat password',
    '{save}' => 'Save',
    '{reset}' => 'Reset',
    '{visible}' => 'Visible',
    '{dashboard}' => 'Dashboard',
    '{content}' => 'Content',
    '{news}' => 'News',
    '{downloads}' => 'Downloads',
    '{links}' => 'Links',
    '{articles}' => 'Articles',
    '{article}' => 'Article',
    '{settings}' => 'Settings',
    '{general}' => 'General',
    '{user}' => 'User',
    '{trash}' => 'Trash',
    '{new user}' => 'New user',
    '{create}' => 'Create',
    '{create news}' => 'Create news',
    '{create download}' => 'Create download',
    '{create link}' => 'Create link',
    '{create article}' => 'Create article',
    '{date}' => 'Date',
    '{title}' => 'Title',
    '{actions}' => 'Actions',
    '{clear selection}' => 'Clear selection',
    '{clear all}' => 'Clear all',
    '{administration}' => 'Administration',
    '{german}' => 'German',
    '{english}' => 'English',
    '{russian}' => 'Russian'
];

$arr_language_ru = [
    '{yes}' => 'да',
    '{no}'  => 'нет',
    '{new}' => 'новый',
    '{firstname}' => 'Имя',
    '{lastname}' => 'Фамилия',
    '{username}' => 'Имя пользователя',
    '{email}' => 'Эл. адрес',
    '{show as public}' => 'Публично показать',
    '{password}' => 'Пароль',
    '{repeat password}' => 'Повторить пароль',
    '{save}' => 'Сохранять',
    '{reset}' => 'Удалить',
    '{visible}' => 'Видимый',
    '{dashboard}' => 'Консоль',
    '{content}' => 'содержание',
    '{news}' => 'Новости',
    '{downloads}' => 'Загрузки',
    '{links}' => 'Связи',
    '{articles}' => 'Артикль',
    '{article}' => 'Артикль',
    '{settings}' => 'Настройки',
    '{general}' => 'Основные',
    '{user}' => 'Пользователь',
    '{trash}' => 'Корзина',
    '{new user}' => 'Новый пользователь',
    '{create}' => 'Создайте',
    '{create news}' => 'Создать новость',
    '{create download}' => 'Создать загрузку',
    '{create link}' => 'Создать связи',
    '{create article}' => 'Создать статью',
    '{date}' => 'Дата',
    '{title}' => 'Звание',
    '{actions}' => 'Поведение',
    '{clear selection}' => 'Очистить выбор',
    '{clear all}' => 'Очистить все',
    '{administration}' => 'Администрация',
    '{german}' => 'Немецкий',
    '{english}' => 'Английский',
    '{russian}' => 'Русский'
];
