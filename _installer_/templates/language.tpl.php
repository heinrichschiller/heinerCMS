<div class="container">
	<header>
        <h2>{header_1}</h2>
    </header>
    <form>
        <div class="row">
    		<div class="col-md-12">
        		<p>{text_1}</p>
        		<p>{text_2}</p>
        		<p>{text_3}</p>
        		<p>{text_4} </p>
    			<select name="lang" class="custom-select" onchange="this.form.submit();">
        			##placeholder-locale-options##
        		</select>
        	</div>
        </div>
        <div class="row button_bottom">
    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    			<a href="index.php?uri=start&lang=##placeholder-lang##&db=mysql" class="btn btn-primary" role="button">{next}</a>
    		</div>
    	</div>
    	<input type="hidden" name="uri" value="language">
    	<input type="hidden" name="db" value="mysql">
    </form>
</div>
