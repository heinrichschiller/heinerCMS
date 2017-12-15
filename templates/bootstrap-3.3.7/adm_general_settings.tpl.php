<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4>
				<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
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
				<input type="text" name="title" value="<?= $_SESSION['title']; ?>" class="form-control" id="title">
			</div>
		</div>
	</div>
    <div class="row">
    	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
             <div class="form-group">
                  <label for="sel1">{theme}:</label>
                  <select class="form-control" id="sel1" name="theme">
                  <?php foreach ($result as $theme) :?>
             		   <option><?= $theme;?></option>
             	 <?php endforeach;?>
                  </select>
            </div> 
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
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
				<button type="submit" class="btn btn-success">Speichern</button>
				<span></span>
				<button type="reset" class="btn btn-danger">Zurücksetzen</button>
			</div>
		</div>
	</div>
</form>