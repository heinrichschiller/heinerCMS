<form action="articleinsert.php" method="post">
	<div class="form-group">
		<label for="title">Titel:</label>
		<input type="text" name="title" class="form-control" id="title">
	</div>
	<div class="form-group">
		<label>Datum:</label> ###time###
	</div>
	<div class="form-group">
		<label for="content">Inhalt:</label>
		<textarea name="content" rows="5" class="form-control" id="content"></textarea>
	</div>
	<div class="checked">
		<label for="visible">Sichtbar?</label>
		<input type="radio" name="visible" value="0" checked> ja 
		<input type="radio" name="visible" value="-1"> nein
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-success">Speichern</button> 
		<button type="reset" class="btn btn-danger">Zurücksetzen</button>
	</div>
</form>