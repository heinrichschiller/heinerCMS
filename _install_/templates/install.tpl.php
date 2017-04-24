<html>
	<head>
		<title>###title###</title>
		<meta charset="utf8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="templates/css/admstyle.css">
	</head>
	<body>
		<div class="container">
			<form method="post" action="../install.php">
				<div class="row">
					<div class="page-header">
						<h2>heinerCMS Installer</h2>
					</div>
					<div class="col-lg-2 col-md-0 col-sm-0 col-sm-0"></div>
					
					<!-- Databases -->

					<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>Datenbank</h4>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Hostname</span>
										<input type="text" name="hostname" class="form-control" placeholder="Hostname" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Username</span>
										<input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Password</span>
										<input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Datenbank</span>
										<input type="text" name="database" class="form-control" placeholder="Database" aria-describedby="basic-addon1">
									</div>
								</div>
							</div>
						</div>
						
						<!-- User -->

						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>Benutzer</h4>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Vorname</span>
										<input type="text" name="hostname" class="form-control" placeholder="Vorname" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Nachname</span>
										<input type="text" name="username" class="form-control" placeholder="Nachname" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Email</span>
										<input type="email" name="password" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Password *</span>
										<input type="password" name="database" class="form-control" placeholder="Passwort" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Password *</span>
										<input type="password" name="database" class="form-control" placeholder="Passwort wiederholen" aria-describedby="basic-addon1">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<button type="submit" class="btn btn-success">Installieren</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
