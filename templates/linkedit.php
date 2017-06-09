<form action="linkupdate.php" method="post">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="ident">#</label><span><?= $result->id;?></span>
				<input type="hidden" name="id" value="###links-id###">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">Titel:</label>
				<input type="text" name="title" value="<?= $result->title;?>" class="form-control" id="title">			
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="uri">URI:</label>
				<input type="text" name="uri" value="<?= $result->uri;?>" class="form-control" id="uid">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="comment">Kommentar:</label>
				<textarea name="comment" rows="10" class="form-control" id="comment"><?= $result->comment;?></textarea>
			</div>
		</div>
	</div>
	<div class="checkbox">
		<span>Sichtbar?</span>
		<input type="radio" name="visible" value="0" <?= $result->visible > -1 ? ' checked' : '';?>> ja
		<input type="radio" name="visible" value="-1" <?= $result->visible < 0 ? ' checked' : '';?>> nein
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-groupt">
				<button type="submit" class="btn btn-success">Speichern</button>
				<span></span>
				<button type="reset" class="btn btn-danger">Zurücksetzen</button>
			</div>
		</div>
	</div>
</form>