<div class="container">
	<header>
		<h2>{header_5}</h2>
		<p>{text_17}</p>
	</header>
	<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<form>
				<div class="form-group">
					{database}:<br>
					<select name="db" class="custom-select" onchange="this.form.submit();">
						##placeholder-db-options##
					</select>
				</div>
				<input type="hidden" name="uri" value="database">
				<input type="hidden" name="lang" value="##placeholder-lang##">
			</form>
			##placeholder-db-type##
		</div>
	</div>
</div>
