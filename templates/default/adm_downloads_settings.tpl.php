<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4><img class="glyph-icon-24" src="../templates/default/img/svg/si-glyph-file-download.svg""> {downloads_settings}</h4>
		</div>
	</div>
</div>
<form action="downloads_settings.php" method="post">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">{tagline}:</label>
				<input type="text" name="tagline" class="form-control" id="title" value="##placeholder-downloads-tagline##">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="comment">{comment}:</label>
				<textarea name="comment" rows="5" class="form-control" id="comment">##placeholder-downloads-comment##</textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<button type="submit" class="btn btn-success">{save}</button>
				<span></span>
				<button type="reset" class="btn btn-danger">{reset}</button>
			</div>
		</div>
	</div>
</form>