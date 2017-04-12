<form action="newsinsert.php" method="post">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">Titel:</label>
				<input type="text" name="title" class="form-control" id="title" required>
			</div>
		</div>
	</div>
	Datum: ###time###
	<div class="form-group">
		<label for="comment">Text:</label>
		<textarea name="message" rows="5" class="form-control" id="comment"></textarea>
	</div>
	<div class="checkbox">
		Sichtbar?<input type="radio" name="visible" value="0" checked> ja <input
			type="radio" name="visible" value="-1"> nein
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<button type="submit" class="btn btn-success">Speichern</button>
			&nbsp
			<button type="reset" class="btn btn-danger">Zurücksetzen</button>
		</div>
	</div>
</form>