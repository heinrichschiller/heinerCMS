<p>
	<a href="$PHP_SELF?uri=newsadd\">{create_news}</a>
</p>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th>#</th>
		<th>{date}</th>
		<th>{title}</th>
		<th>{visible}?</th>
		<th>{actions}</th>
	</tr>
	<tr>
	<?php while ($news = mysqli_fetch_object ( $result ) ) : ?>
    <tr>
    	<td><?= $news->id; ?></td>
    	<td><?= strftime('%d.%m.%Y',$news->datetime); ?></td>
    	<td><?= $news->title; ?></td>
    	<td><?= ($news->visible > -1) ? ' ja' : ' nein'; ?></td>
    	<td>
    		<a href="<?= "$_SERVER[PHP_SELF]?uri=newsedit&id=$news->id"; ?>">{edit}</a> &middot; 
    		<a href="<?= "$_SERVER[PHP_SELF]?uri=newsedit&id=$news->id"; ?>">{copy}</a> &middot; 
    		<a href="<?= "$_SERVER[PHP_SELF]?uri=newsdel&id=$news->id"; ?>">{delete}</a></td>
    </tr>
    <?php endwhile; ?>
	</tr>
</table>