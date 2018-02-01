<!DOCTYPE html>
<html>
    <head>
        <title><@title@></title>
        <meta charset="utf8">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/reboot.min.css">
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/grid.min.css">
		<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="vendor/components/jquery/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<link href="templates/default/css/style.css" rel="stylesheet">
    </head>
    <body>
    	<div class="container-fluid">
            <@navigation@>
        </div>
            <noscript>
            	<div class="alert alert-danger" role="alert">
                        <p>JavaScript ist nicht verf�gbar oder es ist deaktiviert.</p>
                        <p>Bitte verwenden Sie einen Browser, der JavaScript unterst�tzt oder aktivieren Sie JavaScript in Ihrem Browser.</p>
                </div>
            </noscript>
    		<div class="row">
    				<div class="col-sm-12"><@content@></div>
    		</div>
        
        <footer>
            <p>Erstellt mit Bootstrap <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a> 2017</p>
        </footer>
    </body>
</html>
