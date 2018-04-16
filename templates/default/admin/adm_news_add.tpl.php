<div class="row">
   	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
   		<div class="panel">
   			<h4><img class="glyph-icon-24" src="../templates/default/admin/img/svg/si-glyph-pen.svg"> {create_news}</h4>
   		</div>
   	</div>
</div>
<form action="newsinsert.php" method="post">
	<div class="row">
		<div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
			<div class="form-group">
				<label for="ident">#&nbsp;</label><span>{new}</span>
				<input type="hidden" name="id" value="" class="form-control" id="ident">
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
				<input type="text" name="title" value="" class="form-control" id="title" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="text">{text}:</label>
				<textarea name="message" rows="10" class="form-control" id="text"></textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<span>{visible}?</span>
        	<div class="custom-control custom-radio custom-control-inline">
          		<input type="radio" id="customRadioInline1" name="visible" value="0" class="custom-control-input" checked>
          		<label class="custom-control-label" for="customRadioInline1">{yes}</label>
        	</div>
        	<div class="custom-control custom-radio custom-control-inline">
          		<input type="radio" id="customRadioInline2" name="visible" value="-1" class="custom-control-input">
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