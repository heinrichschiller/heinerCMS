<form action="useredit.php" method="post">
	<div class="row">
		<div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
			<div class="form-group">
				<label for="ident">#&nbsp;</label><span><@id@></span>
				<input type="hidden" name="id" value="<@id@>" class="form-control" id="ident">
			</div>
		</div>
		<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group">
				<p class="text-right">Datum: <@datetime@></p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="firstname">Vorname:</label>
				<input type="text" name="firstname" value="<@firstname@>" class="form-control" id="firstname" required>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="lastname">Nachname:</label>
				<input type="text" name="lastname" value="<@lastname@>" class="form-control" id="lastname" required>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="username">Benutzername:</label>
				<input type="text" name="username" value="<@username@>" class="form-control" id="username" required>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" name="email" value="<@email@>" class="form-control" id="email">
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="public_as">Öffentlich anzeigen als:</label>
				<input type="text" name="public_as" value="<@public_as@>" class="form-control" id="public_as">
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="password">Passwort:</label>
				<button type="button" class="btn btn-default" id="password">Passwort generieren</button>
			</div>
		</div>
	</div>
	<div class="checkbox">
		<span>Sichtbar?</span>
		<input type="radio" name="visible" value="0" {visible} > ja 
		<input type="radio" name="visible" value="-1" {visible} > nein
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<button type="submit" class="btn btn-success">Speichern</button>
				<span></span>
				<button type="reset" class="btn btn-danger">Zurücksetzen</button>
			</div>
		</div>
	</div>
</form>