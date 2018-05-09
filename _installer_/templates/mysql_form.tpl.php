    <form method="post" action="databaseinsert.php?lang=##placeholder-lang##">
    	<div class="form-group">
    		<input type="text" name="address" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="{address}" required>
    	</div>
    	<div class="form-group">
    		<input type="text" name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="{user}" required>
    	</div>
    	<div class="form-group">
    		<input type="text" name="database" class="form-control" id="exampleInputPassword1" placeholder="{database}" required>
    		<input type="checkbox" name="new_db" value="1"><small> {text_18} *</small>
    	</div>
    	<div class="form-group">
    		<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="{password}">
    	</div>
    	<button type="submit" class="btn btn-primary btn_bottom">{next}</button>
    	<input type="hidden" name="db" value="mysql">
    </form>
</div>
<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
	<p>{text_19}</p>
	<p>{text_20}</p>
	<p>{text_21} * <small>{text_22}</small></p>
	<p>{text_23}</p>
</div>