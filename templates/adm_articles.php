<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Artikel</h4>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Datum</th>
					<th>Titel</th>
					<th>Sichtbar?</th>
					<th>Aktionen</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($article = mysqli_fetch_object ( $result ) ) : ?>
				<tr>
					<td><?= strftime('%d.%m.%Y',$article->datetime); ?></td>
					<td><?= $article->title; ?></td>
					<td><?= ($article->visible > -1) ? ' ja' : ' nein'; ?></td>
					<td><a href="<?= "$_SERVER[PHP_SELF]?uri=articleedit&id=$article->id"; ?>">
							<span class="glyphicon glyphicon-edit" aria-hidden="true" title="Edit"></span></a> &middot; 
						<a href="<?= "$_SERVER[PHP_SELF]?uri=articleedit&id=$article->id"; ?>">
							<span class="glyphicon glyphicon-duplicate" aria-hidden="true" title="Edit"></span></a> &middot; 
						<a href="<?= "$_SERVER[PHP_SELF]?uri=articledel&id=$article->id"; ?>">
							<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<a href="$PHP_SELF?uri=articleadd" class="btn btn-primary" role="button">Artikel erstellen</a>
	</div>
</div>