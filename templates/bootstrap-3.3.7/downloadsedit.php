<form action="downloadsupdate.php" method="post">
	<div class="row">
		<div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
			<div class="form-group">
				<label for="ident">#&nbsp;</label><span><?= $result->id; ?></span>
				<input type="hidden" name="id" value="<?= $result->id; ?>">
			</div>
		</div>
		<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group">
				<p class="text-right">Datum: <?= strftime ( '%d.%m.%Y %H:%M', $result->datetime ); ?></p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">Title:</label>
				<input type="text" name="title" value="<?= $result->title; ?>" class="form-control" id="title">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="path">Pfad:</label>
				<input type="text" name="path" value="<?= $result->path; ?>" class="form-control" id="path">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="filename">Dateiname:</label>
				<input type="text" name="filename" value="<?= $result->filename; ?>" class="form-control" id="filename">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="comment">Kommentar:</label>
				<textarea name="comment" rows="10" class="form-control" id="comment"><?= $result->comment; ?></textarea>
			</div>
		</div>
	</div>
	<div class="checkbox">
		<span>Sichtbar?</span>
		<input type="radio" name="visible" value="0" <?= $result->visible > -1 ? ' checked' : ''; ?>> ja 
		<input type="radio" name="visible" value="-1" <?= $result->visible < 0 ? ' checked' : ''; ?>> nein
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