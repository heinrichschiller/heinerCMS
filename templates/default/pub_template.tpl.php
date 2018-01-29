<!DOCTYPE html>
<html>
    <head>
        <title><@title@></title>
        <meta charset="utf8">

        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="vendor/components/jquery/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<link href="templates/css/style.css" rel="stylesheet">
    </head>
    <body>
    	<div class="container-fluid">
             <@navigation@>


        <noscript>
        	<div class="alert alert-danger" role="alert">
                    <p>JavaScript ist nicht verfügbar oder es ist deaktiviert.</p>
                    <p>Bitte verwenden Sie einen Browser, der JavaScript unterstützt oder aktivieren Sie JavaScript in Ihrem Browser.</p>
            </div>
        </noscript>
		<div class="row">
				<div class="col-sm-12"><@content@></div>
		</div>
        <footer class="container-fluid bg-4 text-center">
            <p>Erstellt mit Bootstrap <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a> 2017</p>
        </footer>
</html>
