<div class="container">
    <header>
        	<h2>Benutzer anlegen</h2>
        	<p>Hier wird der erste Benutzer angelegt. Weitere Benutzer können über <strong>Einstellungen</strong> angelegt werden.</p>
    	</header>
    	<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <form method="post" action="userinsert.php">
            	<div class="form-group">
                    <input type="text" name="firstname" class="form-control" placeholder="Vorname" value="" required>
    			</div>
            	<div class="form-group">
                <input type="text" name="lastname" class="form-control" placeholder="Nachname" required>
			</div>
			<div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                <small id="emailHelp" class="form-text text-muted">Wir teilen die Email-Adresse niemandem weiter.</small>
			</div>
			<div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Benutzername" value="" required>
    			</div>
			<div class="form-group">
                <input type="password" name="password1" class="form-control" placeholder="Password" required>
			</div>
			<div class="form-group">
                <input type="password" name="password2" class="form-control" placeholder="Password wiederholen" required>
			</div>
			<button type="submit" class="btn btn-primary btn_bottom">Weiter</button>
    		</form>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<p>Vorname des Benutzers</p>
		<p>Nachname des Benutzers</p>
		<p>Email des Benutzers. Email wird für die Anmeldung benötigt.</p>
		<p>Benutzername des Benutzers. Wird verwendet um den Autor eines Beitrags anzuzeigen.</p>
		<p>Passwort für die Anmeldung.</p>
		<p>Passwort wiederholen um die korrektheit zu bestätigen.</p>
	</div>
</div>
</div>