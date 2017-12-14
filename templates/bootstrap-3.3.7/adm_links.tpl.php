<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Links</h4>
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
				<?php while ($link = mysqli_fetch_object ( $result ) ) : ?>
				<tr>
					<td><?= $link->id; ?></td>
					<td><?= $link->title; ?></td>
					<td><?= ($link->visible > -1) ? ' ja' : ' nein'; ?></td>
					<td><a href="<?= "$_SERVER[PHP_SELF]?uri=linkedit&id=$link->id"; ?>">
							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot; 
						<a href="<?= "$_SERVER[PHP_SELF]?uri=linkedit&id=$link->id"; ?>">
							<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot; 
						<a href="<?= "$_SERVER[PHP_SELF]?uri=linkdel&id=$link->id"; ?>">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<a href="$PHP_SELF?uri=linkadd" class="btn btn-primary" role="button">{create link}</a>
	</div>
</div>