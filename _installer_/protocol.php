<?php 

session_start();

//////////////////////////////////////////////////////////////////////////////////////////////////
// Found cms-config.php ?
//////////////////////////////////////////////////////////////////////////////////////////////////

$filename = __DIR__ . '/../cms-config.php';

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
// Created Newstable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabNewsCreated']) {
    $newsTrAttr = 'class="table-success"';
    $newsRes = 'ja';
} else {
    $newsTrAttr = 'class="table-danger"';
    $newsRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created News Settings table ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabNewsSettingsCreated']) {
    $newsSettingsTrAttr = 'class="table-success"';
    $newsSettingsRes = 'ja';
} else {
    $newsSettingsTrAttr = 'class="table-danger"';
    $newsSettingsRes = 'nein';
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
    $artiklesTrAttr = 'class="table-success"';
    $artiklesRes = 'ja';
} else {
    $artiklesTrAttr = 'class="table-danger"';
    $artiklesRes = 'nein';
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Created Sitesstable ?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isTabSitesCreated']) {
    $sitesTrAttr = 'class="table-success"';
    $sitesRes = 'ja';
} else {
    $sitesTrAttr = 'class="table-danger"';
    $sitesRes = 'nein';
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
// Is news configuration written?
//////////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['isNewsConfWritten']) {
    $isNewsConfTrAttr = 'class="table-success"';
    $isNewsRes = 'ja';
} else {
    $isNewsConfTrAttr = 'class="table-danger"';
    $isNewsRes = 'nein';
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
							<tr <?= $newsTrAttr; ?>>
								<td>Tabelle news erstellt?</td>
								<td><?= $newsRes; ?></td>
							</tr>
							<tr <?= $newsSettingsTrAttr; ?>>
								<td>Tabelle news_settings erstellt?</td>
								<td><?= $newsSettingsRes; ?></td>
							</tr>
							<tr <?= $downloadsTrAttr; ?>>
								<td>Tabelle downloads erstellt?</td>
								<td><?= $downloadsRes; ?></td>
							</tr>
							<tr <?= $linksTrAttr; ?>>
								<td>Tabelle links erstellt?</td>
								<td><?= $linksRes; ?></td>
							</tr>
							<tr <?= $linksSettingsTrAttr; ?>>
								<td>Tabelle links_settings erstellt?</td>
								<td><?= $linksSettingsRes; ?></td>
							</tr>
							<tr <?= $artiklesTrAttr; ?>>
								<td>Tabelle articles erstellt?</td>
								<td><?= $artiklesRes; ?></td>
							</tr>
							<tr <?= $sitesTrAttr; ?>>
								<td>Tabelle sites erstellt?</td>
								<td><?= $sitesRes; ?></td>
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
							<tr <?= $isNewsConfTrAttr; ?>>
								<td>Standardkonfiguration für News geschrieben?</td>
								<td><?= $isNewsRes ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	</div>
	<footer>
		<p>
			Copyright <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a>
			2018
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