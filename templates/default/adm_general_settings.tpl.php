<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4>
				<img class="glyph-icon-24" src="../templates/default/img/svg/si-glyph-gear.svg">
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
				<input type="text" name="title" value="<@title@>" class="form-control" id="title">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="tagline">{tagline}:</label>
				<input type="text" name="tagline" value="<@tagline@>" class="form-control" id="tagline">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
			<div class="form-group">
				<label for="blogUrl">{blog}-URL:</label>
				<input type="text" name="blogUrl" value="<@blog-url@>" class="form-control" id="blogUrl">
			</div>
		</div>
	</div>
    <div class="row">
    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
             <div class="form-group">
                  <label for="sel1">{theme}:</label>
                  <select class="form-control" id="sel1" name="theme">
					<@theme-placeholder@>
                  </select>
            </div> 
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
             <div class="form-group">
                  <label for="sel1">{site_language}:</label>
                  <select class="form-control" id="sel1" name="language">
             		   <option>{german}</option>
             		   <option>{english}</option>
             		   <option>{russian}</option>
                  </select>
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