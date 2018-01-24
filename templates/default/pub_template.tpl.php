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
        	<nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <a class="navbar-brand" href="#"><@title@></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                      <@navigation@>
                    </div>
                  </div>
                  <ul class="nav justify-content-end">
                      <li class="nav-item">
                        <a class="nav nav-link" href="?uri=admin">Sign in</a>
                      </li>
                  </ul>
            </nav>

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
