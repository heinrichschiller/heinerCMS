<html>
	<head>
		<title><@title@></title>
		<meta charset="utf8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap-reboot.min.css">
		<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap-grid.min.css">
		<link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="../vendor/components/jquery/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

		<link href="../templates/default/css/admstyle.css" rel="stylesheet">
	</head>
	<body>
        <div class="container-fluid">
        	<nav class="navbar navbar-light bg-light">
  				<a class="navbar-brand" href="#"><@title@> - {administration}</a>
  				<ul class="nav justify-content-end">
                      <li class="nav-item">
                        <a class="nav nav-link" href="?uri=logout">Sign out</a>
                      </li>
                  </ul>
			</nav>
        	<div class="row">
        		<div class="col-sm-12">
                    <noscript>
                    	<div class="container">
                    	  	<div class="alert alert-danger" role="alert">
                                <p>JavaScript ist nicht verfügbar oder es ist deaktiviert.</p>
                                <p>Bitte verwenden Sie einen Browser, der JavaScript unterstützt oder aktivieren Sie JavaScript in Ihrem Browser.</p>
                            </div>
                        </div>
                    </noscript>
                </div>
            </div>
            <div class="row navi">
        		<div class="col-xl-3 col-lg-3 col-xs-12" id="hidden">
        			<@navigation@>
        		</div>
        		<div class="leiste" id="hide"></div>
        	    <div class="col-xl-6 col-lg-9 col-xs-12 content-section">
        	    	<@content@>
        	    </div>
    	    </div>
    		<footer class="container-fluid bg-4 text-center">
      		    <a href="https://www.heinrich-schiller.de">www.heinrich-schiller.de</a>
        	</footer>
    	</div>
        
        <!-- TinyMCE-Editor -->
		<script src="../vendor/tinymce/tinymce/tinymce.min.js"></script>
  		<script>tinymce.init({ selector:'textarea' });</script>
  		
  		<script src="../templates/default/js/main.js"></script>
	</body>
</html>
