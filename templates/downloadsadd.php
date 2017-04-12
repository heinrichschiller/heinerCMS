<form action="downloadsinsert.php" method="post">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">Titel:</label>
				<input type="text" name="title" value="" class="form-control" id="title" required>
			</div>
		</div>
	</div>
	Datum:###time### 
	<div class="form-group">
		<label for="path">Pfad:</label>
		<input type="text" name="path" class="form-control" id="path" required>
	</div>
	<div class="form-group">
		<label for="filename">Dateiname:</label>
		<input type="text" name="filename" class="form-control" id="filename" required>
	</div>
	<div class="form-group">
		<label for="comment">Kommentar:</label>
		<textarea name="comment" rows="5" class="form-control" id="comment"></textarea>
	</div>
	<div class="checked">
	Sichtbar?<input type="radio" name="visible" value="0" checked> ja <input
		type="radio" name="visible" value="-1"> nein 
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-success">Speichern</button>
		&nbsp
		<button type="reset" class="btn btn-danger">Zurücksetzen</button>
	</div>
</form>