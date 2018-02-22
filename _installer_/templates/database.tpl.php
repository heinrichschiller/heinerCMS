<div class="container">
    	<header>
        	<h2>Datenbank</h2>
        	<p>Der heinerCMS-Installer bringt sie sicher durch die Installation.</p>
    	</header>
    	<div class="row">
        	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <form method="post" action="databaseinsert.php">
            		<div class="form-group">
                    <input type="text" name="address" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Adresse" required>
        			</div>
                	<div class="form-group">
                    <input type="text" name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Benutzer" required>
        			</div>
        			<div class="form-group">
                    <input type="text" name="database" class="form-control" id="exampleInputPassword1" placeholder="Datenbank" required>
                    <input type="checkbox" name="new_db" value="1"><small> Neue Datenbank erstellen, wenn möglich. *</small>
        			</div>
        			<div class="form-group">
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        			</div>
        			<button type="submit" class="btn btn-primary btn_bottom">Weiter</button>
            	</form>
        </div>
    		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
    			<p>Adresse - Entweder <strong>localhost</strong> oder die Webadresse ihres Webhosters.</p>
    			<p>Benutzer - Der Benutzer der Datenbank zb. <strong>root</strong>. Wird auch von ihrem Provider bereitgestellt.</p>
    			<p>Datenbank - Name ihrer Datenbank. Wird auch von ihrem Provider bereitgestellt. * <small>Wenn sie die Option <strong>Neue Datenbank erstellen, wenn möglich</strong>
    			aktiviert haben, kann einen neue Datenbank nur angelegt werden, falls sie auch die Berechtigungen dafür haben. Sonst schlägt das erstellen einen neuen
    			Datenbank fehl.</small></p>
    			<p>Passwort - Passwort der Datenbank. Wird auch von ihrem Provider bereitgestellt.</p>
		</div>
	</div>
</div>
