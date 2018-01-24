<div class="container-fluid">
    <div class="row">
    	<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="panel">
				<h4><img class="glyph-icon-24" src="../templates/default/img/svg/si-glyph-document.svg"> {sites}</h4>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    		<table class="table table-hover table-striped">
    			<thead>
    				<tr>
        				<th>#</th>
        				<th>{date}</th>
        				<th>{title}</th>
        				<th>{visible}?</th>
        				<th>{actions}</th>
    				</tr>
    			</thead>
    			<tbody>
    				<@sites-content@>
    			</tbody>
    		</table>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    		<a href="$PHP_SELF?uri=siteadd" class="btn btn-primary" role="button">{create_site}</a>
    	</div>
    </div>
</div>