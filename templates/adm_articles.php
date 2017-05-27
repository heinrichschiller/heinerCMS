<div class="container-fluid">
	<div class="panel">
		<h4><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Artikel</h4>
	</div>
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
		<?php 
		
		$table_content = '';
		
		while ( $articles = mysqli_fetch_object ( $result ) ) {
		    $table_content .= '<tr><td>' . StrFTime ( '%d.%m.%Y %H:%M', $articles->datetime );
		    $table_content .= "</td><td>$articles->title</td><td>" . (($articles->visible > - 1) ? 'ja' : 'nein');
		    $table_content .= "</td><td><a href=\"$_SERVER[PHP_SELF]?uri=articleedit&id=$articles->id\">Bearbeiten</a> &middot; <a href=\"$_SERVER[PHP_SELF]?uri=articledel&id=$articles->id\">Löschen</a></tr>";
		}
		echo $table_content;
		?>
		</tbody>
	</table>
	<a href="$PHP_SELF?uri=articleadd" class="btn btn-primary" role="button">Artikel erstellen</a>
</div>