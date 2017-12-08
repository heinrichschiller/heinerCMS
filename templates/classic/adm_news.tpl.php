<p>
	<a href="$PHP_SELF?uri=newsadd\">News erstellen</a>
</p>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th>#</th>
		<th>Datum</th>
		<th>Titel</th>
		<th>Sichtbar?</th>
		<th>Aktionen</th>
	</tr>
	<tr>
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
	</tr>
</table>