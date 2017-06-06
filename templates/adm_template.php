<html>
	<head>
		<title>###title###</title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="../vendor/components/jquery/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		
		<!-- TinyMCE-Editor -->
		<script src="../vendor/tinymce/tinymce/tinymce.min.js"></script>
  		<script>tinymce.init({ selector:'textarea' });</script>
		<link href="../templates/css/admstyle.css">
	</head>
	<body>
        <nav class="navbar navbar-inverse">
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
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="?uri=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
		<div class="col-xs-12 col-sm-4 col-md-2">###navigation###</div>
	    <div class="col-xs-12 col-sm-8 col-md-8">###content###</div>
		<footer class="footer">
        	<p>Erstellt mit Bootstrap <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a> 2017</p>
        </footer>
	</body>
</html>
