<div class="container-fluid">
    <div class="row">
    	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
    		<div class="panel">
    			<h4><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {news}</h4>
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
    				<?php while ($news = mysqli_fetch_object ( $result ) ) : ?>
    				<tr>
    					<td><?= $news->id; ?></td>
    					<td><?= strftime('%d.%m.%Y',$news->datetime); ?></td>
    					<td><?= $news->title; ?></td>
    					<td><?= ($news->visible > -1) ? ' ja' : ' nein'; ?></td>
    					<td><a href="<?= "$_SERVER[PHP_SELF]?uri=newsedit&id=$news->id"; ?>">
    							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot; 
    						<a href="<?= "$_SERVER[PHP_SELF]?uri=newsedit&id=$news->id"; ?>">
    							<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot; 
    						<a href="<?= "$_SERVER[PHP_SELF]?uri=newsdel&id=$news->id"; ?>">
    							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
    				</tr>
    				<?php endwhile; ?>
    			</tbody>
    		</table>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    		<a href="$PHP_SELF?uri=newsadd" class="btn btn-primary" role="button">{create news}</a>
    	</div>
    </div>
</div>