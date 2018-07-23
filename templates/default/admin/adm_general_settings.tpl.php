<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4>
				<img class="glyph-icon-24" src="../templates/default/admin/img/svg/si-glyph-gear.svg">
				{settings}
			</h4>
		</div>
	</div>
</div>
<form action="general_settings.php" method="post">
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
				<input type="text" name="tagline" value="##placeholder-tagline##" class="form-control" id="tagline">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
			<div class="form-group">
				<label for="blogUrl">{blog}-URL:</label>
				<input type="text" name="blogUrl" value="##placeholder-blog-url##" class="form-control" id="blogUrl">
			</div>
		</div>
	</div>
    <div class="row">
    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
             <div class="form-group">
                <label for="sel1">{theme}:</label>
                <select class="custom-select" id="sel1" name="theme">
					##placeholder-option-theme##
				</select>
            </div> 
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
             <div class="form-group">
                  <label for="sel1">{application_language}:</label>
                  <select class="custom-select" id="sel1" name="language" onchange="this.form.submit();">
                  	##placeholder-option-locale##
                  </select>
            </div> 
        </div>
    </div>
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="discalimer">{footer}:</label>
				<input type="text" name="footer" value="##placeholder-footer##" class="form-control" id="footer">
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
