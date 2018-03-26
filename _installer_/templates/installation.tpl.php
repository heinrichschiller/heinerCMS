<div class="container">
	<header>
    	<h2>{header_7}</h2>
    </header>
    <p>{text_32} <strong>cms-config.php</strong> {text_33}</p>
    <p>{text_34}</p>
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

?>
    </textarea>
    <div class="row button_bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<a href="install.php?lang=##placeholder-lang##" class="btn btn-primary" role="button">{next}</a>
        </div>
	</div>
</div>
