<div class="container">
	<header>
    		<h2>Installation</h2>
        <p>Kopieren sie folgende Zeilen und erstellen sie die Datei: <strong>cms-config.php</strong> auf ihrem Computer.</p>
        <p>Fügen sie die kopierten Zeilen ein und speichern sie die Datei ab. Anschließend legen sie die Konfigurationsdatei in das Projektverzeichnis und klicken auf Weiter um die Installation zu beginnen.
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="12">
<?php

//////////////////////////////////////////////////////////////////////////
// MySQL settings
//////////////////////////////////////////////////////////////////////////

// MySQL hostname
define('DB_HOST', '##placeholder_database_address##');

// MySQL database username
define('DB_USER', '##placeholder_database_user##');

// The name of the database
define('DB_NAME', '##placeholder_database_name##');

// MySQL database password
define('DB_PASSWORD', '##placeholder_database_password##');
        </textarea>
    	</header>
    	<div class="row button_bottom">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<a href="install.php" class="btn btn-primary" role="button">Weiter</a>
        	</div>
	</div>
</div>