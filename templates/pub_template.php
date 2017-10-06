<!DOCTYPE html>
<html>
    <head>
        <title>###title###</title>
        <meta charset="utf8">

        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="vendor/components/jquery/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<link href="templates/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">###title###</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        ###navigation###
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="?uri=admin"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">###content###</div>
			</div>
		</div>
        <footer class="container-fluid bg-4 text-center">
            <p>Erstellt mit Bootstrap <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a> 2017</p>
        </footer>
</html>
