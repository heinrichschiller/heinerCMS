<?php 

session_start();

//////////////////////////////////////////////////////////////////////////////////////////////////
// Found cms-config.php ?
//////////////////////////////////////////////////////////////////////////////////////////////////

$filename = __DIR__ . '/../config/cms-config.php';

if(file_exists($filename)) {
    $configTrAttr = 'class="table-success"';
    $configRes = 'ja';
} else {
    $configTrAttr = 'class="table-danger"';
    $configRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Connect to database ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isConnected']) {
    $databaseTrAttr = 'class="table-success"';
    $databaseRes = 'ja';
} else {
    $databaseTrAttr = 'class="table-danger"';
    $databaseRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Downloads Settings table ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabDownloadsSettingsCreated']) {
    $downloadsSettingsTrAttr = 'class="table-success"';
    $downloadsSettingsRes = 'ja';
} else {
    $downloadsSettingsTrAttr = 'class="table-danger"';
    $downloadsSettingsRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Downloadstable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabDownloadsCreated']) {
    $downloadsTrAttr = 'class="table-success"';
    $downloadsRes = 'ja';
} else {
    $downloadsTrAttr = 'class="table-danger"';
    $downloadsRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Linkstable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabLinksCreated']) {
    $linksTrAttr = 'class="table-success"';
    $linksRes = 'ja';
} else {
    $linksTrAttr = 'class="table-danger"';
    $linksRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Links Settings table ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabLinksSettingsCreated']) {
    $linksSettingsTrAttr = 'class="table-success"';
    $linksSettingsRes = 'ja';
} else {
    $linksSettingsTrAttr = 'class="table-danger"';
    $linksSettingsRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Artiklestable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabArticlesCreated']) {
    $articlesTrAttr = 'class="table-success"';
    $articlesRes = 'ja';
} else {
    $articlesTrAttr = 'class="table-danger"';
    $articlesRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Links Settings table ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabArticlesSettingsCreated']) {
    $articlesSettingsTrAttr = 'class="table-success"';
    $articlesSettingsRes = 'ja';
} else {
    $articlesSettingsTrAttr = 'class="table-danger"';
    $articlesSettingsRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Pagestable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabPagesCreated']) {
    $pagesTrAttr = 'class="table-success"';
    $pagesRes = 'ja';
} else {
    $pagesTrAttr = 'class="table-danger"';
    $pagesRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Settingsstable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabSettingsCreated']) {
    $settingsTrAttr = 'class="table-success"';
    $settingsRes = 'ja';
} else {
    $settingsTrAttr = 'class="table-danger"';
    $settingsRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Userstable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabNewsCreated']) {
    $usersTrAttr = 'class="table-success"';
    $usersRes = 'ja';
} else {
    $usersTrAttr = 'class="table-danger"';
    $usersRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created user ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isUserCreated']) {
    $isUsersTrAttr = 'class="table-success"';
    $isUsersRes = 'ja';
} else {
    $isUsersTrAttr = 'class="table-danger"';
    $isUsersRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Is default configuration written?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isDefaultConfWritten']) {
    $isConfTrAttr = 'class="table-success"';
    $isConfRes = 'ja';
} else {
    $isConfTrAttr = 'class="table-danger"';
    $isConfRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Is links configuration written?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isLinksConfWritten']) {
    $isLinksConfTrAttr = 'class="table-success"';
    $isLinksRes = 'ja';
} else {
    $isLinksConfTrAttr = 'class="table-danger"';
    $isLinksRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Is articles configuration written?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isArticlesConfWritten']) {
    $isArticlesConfTrAttr = 'class="table-success"';
    $isArticlesRes = 'ja';
} else {
    $isArticlesConfTrAttr = 'class="table-danger"';
    $isArticlesRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Is downloads configuration written?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isDownloadsConfWritten']) {
    $isDownloadsConfTrAttr = 'class="table-success"';
    $isDownloadsRes = 'ja';
} else {
    $isDownloadsConfTrAttr = 'class="table-danger"';
    $isDownloadsRes = 'nein';
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Protokoll</title>
<meta charset="utf8">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="../vendor/twbs/bootstrap/dist/css/reboot.min.css">
<link rel="stylesheet"
	href="../vendor/twbs/bootstrap/dist/css/grid.min.css">
<link rel="stylesheet"
	href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<style type="text/css">
/* button */
.button_bottom {
	position: fixed;
	bottom: 10em;
	left: auto;
	right: auto;
}

/* footer */
footer {
	height: 10em;
	line-height: 10em;
	position: relative;
	bottom: 0;
	left: 0;
	right: 0;
}

footer p {
	text-align: center;
}
</style>
</head>
<body>
	<div class="container">
		<header>
			<h2>Protokoll</h2>
		</header>
		<div class="overwhelm">
			<div class="row">
				<div class="col-md-12">
					<h3>Konfigurationsdatei</h3>
					<table class="table">
						<thead>
						</thead>
						<tbody>
							<tr <?= $configTrAttr; ?>>
								<td>Konfigurationsdatei <strong>cms-config.php</strong> gefunden?</td>
								<td><?= $configRes ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3>Datenbank</h3>
					<table class="table">
						<thead>
						</thead>
						<tbody>
							<tr <?= $databaseTrAttr; ?>>
								<td>Verbindung zur Datenbank erfolgreich?</td>
								<td><?= $databaseRes; ?></td>
							</tr>
							<tr <?= $downloadsTrAttr; ?>>
								<td>Tabelle downloads erstellt?</td>
								<td><?= $downloadsRes; ?></td>
							</tr>
							<tr <?= $downloadsSettingsTrAttr; ?>>
								<td>Tabelle downloads_settings erstellt?</td>
								<td><?= $downloadsSettingsRes; ?></td>
							</tr>
							<tr <?= $linksTrAttr; ?>>
								<td>Tabelle links erstellt?</td>
								<td><?= $linksRes; ?></td>
							</tr>
							<tr <?= $linksSettingsTrAttr; ?>>
								<td>Tabelle links_settings erstellt?</td>
								<td><?= $linksSettingsRes; ?></td>
							</tr>
							<tr <?= $articlesTrAttr; ?>>
								<td>Tabelle articles erstellt?</td>
								<td><?= $articlesRes; ?></td>
							</tr>
							<tr <?= $articlesSettingsTrAttr; ?>>
								<td>Tabelle articles_settings erstellt?</td>
								<td><?= $articlesSettingsRes; ?></td>
							</tr>
							<tr <?= $pagesTrAttr; ?>>
								<td>Tabelle pages erstellt?</td>
								<td><?= $pagesRes; ?></td>
							</tr>
							<tr <?= $settingsTrAttr; ?>>
								<td>Tabelle settings erstellt?</td>
								<td><?= $settingsRes; ?></td>
							</tr>
							<tr <?= $usersTrAttr; ?>>
								<td>Tabelle users erstellt?</td>
								<td><?= $usersRes; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3>Benutzer</h3>
					<table class="table">
						<thead>
						</thead>
						<tbody>
							<tr <?= $isUsersTrAttr; ?>>
								<td>Benutzer angelegt?</td>
								<td><?= $isUsersRes ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3>Standardeinstellungen</h3>
					<table class="table">
						<thead>
						</thead>
						<tbody>
							<tr <?= $isConfTrAttr; ?>>
								<td>Standardkonfiguration geschrieben?</td>
								<td><?= $isConfRes ?></td>
							</tr>
							<tr <?= $isLinksConfTrAttr; ?>>
								<td>Standardkonfiguration für Links geschrieben?</td>
								<td><?= $isLinksRes ?></td>
							</tr>
							<tr <?= $isArticlesConfTrAttr; ?>>
								<td>Standardkonfiguration für Artikel geschrieben?</td>
								<td><?= $isArticlesRes ?></td>
							</tr>
							<tr <?= $isDownloadsConfTrAttr; ?>>
								<td>Standardkonfiguration für Downloads geschrieben?</td>
								<td><?= $isDownloadsRes ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<p>
			Copyright <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a>
			2017 - 2018
		</p>
	</footer>

	<!-- jQuery library -->
	<script src="../vendor/components/jquery/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php

/* Wert setzen */
session_unset();

/* Session beenden */
session_destroy ();

?>