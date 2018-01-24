<form action="downloadsinsert.php" method="post">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">{title}:</label>
				<input type="text" name="title" value="" class="form-control" id="title" required>
			</div>
		</div>
	</div>
	{date}:<@time@> 
	<div class="form-group">
		<label for="path">{path}:</label>
		<input type="text" name="path" class="form-control" id="path" required>
	</div>
	<div class="form-group">
		<label for="filename">{filename}:</label>
		<input type="text" name="filename" class="form-control" id="filename" required>
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