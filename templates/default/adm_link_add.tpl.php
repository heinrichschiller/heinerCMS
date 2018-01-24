<form action="linkinsert.php" method="post">
	<div class="form-group">
		<label for="title">{title}:</label>
		<input type="text" name="title" class="form-control" id="title" required>
	</div>
	<div class="form-group">
		<label for="uri">{uri}:</label>
		<input type="text" name="uri" class="form-control" id="uri">
	</div>
	<div class="form-group">
		<label for="comment">{comment}:</label>
		<textarea name="comment" rows="5" class="form-control" id="comment"></textarea>
	</div>
	<div class="checked">
		{visible}?
		<input type="radio" name="visible" value="0" checked> {yes} 
		<input type="radio" name="visible" value="-1"> {no}
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-success">{save}</button>
		<span></span>
		<button type="reset" class="btn btn-danger">{reset}</button>
	</div>
</form>