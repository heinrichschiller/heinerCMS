<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4>
				<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
				##placeholder-header##
			</h4>
		</div>
	</div>
</div>
<form action="##placeholder-action##" method="post">
	<div class="row">
		<div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
			<div class="form-group">
				<label for="ident">#&nbsp;</label><span>##placeholder-id##</span>
				<input type="hidden" name="id" value="##placeholder-id##" class="form-control" id="ident">
			</div>
		</div>
		<div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group">
				<p class="text-right">{date}: ##placeholder-datetime##</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="title">{title}:</label>
				<input type="text" name="title" value="##placeholder-title##" class="form-control" id="title">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="tagline">{tagline}:</label>
				<input type="text" name="tagline" value="##placeholder-tagline##" class="form-control" id="tagline" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="text">{text}:</label>
				<textarea name="text" rows="10" class="form-control" id="text">##placeholder-content##</textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<span>{visible}?</span>
        	<div class="custom-control custom-radio custom-control-inline">
          		<input type="radio" id="customRadioInline1" name="visibility" value="true" class="custom-control-input" ##placeholder-chk_yes##>
          		<label class="custom-control-label" for="customRadioInline1">{yes}</label>
        	</div>
        	<div class="custom-control custom-radio custom-control-inline">
          		<input type="radio" id="customRadioInline2" name="visibility" value="false" class="custom-control-input" ##placeholder-chk_no##>
          		<label class="custom-control-label" for="customRadioInline2">{no}</label>
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