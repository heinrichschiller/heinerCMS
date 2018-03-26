<div class="container">
    <header>
        	<h2>{header_6}</h2>
        	<p>{text_24}</p>
    </header>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <form method="post" action="userinsert.php?lang=##placeholder-lang##">
                <div class="form-group">
                    <input type="text" name="firstname" class="form-control" placeholder="{firstname}" value="" required>
        		</div>
               	<div class="form-group">
                    <input type="text" name="lastname" class="form-control" placeholder="{lastname}" required>
			    </div>
			    <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="{email}" required>
                    <small id="emailHelp" class="form-text text-muted">{text_25}</small>
			    </div>
			    <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="{username}" value="" required>
        			</div>
			    <div class="form-group">
                    <input type="password" name="password1" class="form-control" placeholder="{password}" required>
			    </div>
			    <div class="form-group">
                    <input type="password" name="password2" class="form-control" placeholder="{repeat_password}" required>
			    </div>
			    <button type="submit" class="btn btn-primary btn_bottom">{next}</button>
        	</form>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		    <p>{text_26}</p>
		    <p>{text_27}</p>
		    <p>{text_28}</p>
		    <p>{text_29}</p>
		    <p>{text_30}</p>
		    <p>{text_31}</p>
	    </div>
    </div>
</div>
