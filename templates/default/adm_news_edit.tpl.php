<div class="row">
   	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
   		<div class="panel">
   			<h4><img class="glyph-icon-24" src="../templates/default/img/svg/si-glyph-pen.svg"> {edit_news}</h4>
   		</div>
   	</div>
</div>
<form action="newsupdate.php" method="post">
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
				<label for="text">{text}:</label>
				<textarea name="message" rows="10" class="form-control" id="text">##placeholder-message##</textarea>
			</div>
		</div>
	</div>
	<div class="checkbox">
		<span>{visible}?</span>
		<input type="radio" name="visible" value="0" ##placeholder-chk_yes## > {yes} 
		<input type="radio" name="visible" value="-1" ##placeholder-chk_no## > {no}
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