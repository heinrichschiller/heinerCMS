<form action="linkinsert.php" method="post">
	<div class="form-group">
		<label for="title">Titel:</label>
		<input type="text" name="title" class="form-control" id="title" required>
	</div>
	<div class="form-group">
		<label for="uri">URI:</label>
		<input type="text" name="uri" class="form-control" id="uri">
	</div>
	<div class="form-group">
		<label for="comment">Kommentar:</label>
		<textarea name="comment" rows="5" class="form-control" id="comment"></textarea>
	</div>
	<div class="checked">
		Sichtbar?
		<input type="radio" name="visible" value="0" checked> ja 
		<input type="radio" name="visible" value="-1"> nein
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-success">Speichern</button>
		<span></span>
		<button type="reset" class="btn btn-danger">Zurücksetzen</button>
	</div>
</form>