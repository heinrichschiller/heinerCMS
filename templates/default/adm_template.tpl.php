<html>
	<head>
		<title><@title@></title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="../vendor/components/jquery/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

		<link href="../templates/bootstrap-3.3.7/css/admstyle.css">
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
                    <a class="navbar-brand" href="#"><@title@> - {administration} </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="?uri=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <noscript>
        	<div class="container">
        	  	<div class="alert alert-danger" role="alert">
                    <p>JavaScript ist nicht verfügbar oder es ist deaktiviert.</p>
                    <p>Bitte verwenden Sie einen Browser, der JavaScript unterstützt oder aktivieren Sie JavaScript in Ihrem Browser.</p>
                </div>
            </div>
        </noscript>
		<div class="col-xs-12 col-sm-5 col-md-4 col-lg-3"><@navigation@></div>
	    <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><@content@></div>
	    
		<footer class="container-fluid bg-4 text-center">
  		    <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a>
    		</footer>
        
        <!-- TinyMCE-Editor -->
		<script src="../vendor/tinymce/tinymce/tinymce.min.js"></script>
  		<script>tinymce.init({ selector:'textarea' });</script>
  		
  		<script src="../templates/bootstrap-3.3.7/js/main.js"></script>
	</body>
</html>
