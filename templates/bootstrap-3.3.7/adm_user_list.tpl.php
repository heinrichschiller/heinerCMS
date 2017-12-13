<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4>
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				Benutzer
			</h4>
		</div>
	</div>
</div>
<table class="table table-hover table-striped">
	<thead>
		<tr>
    		<th>#</th>
    		<th>Name</th>
    		<th>Role</th>
    		<th>Aktiv</th>
    		<th>Aktion</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>'.$values['id'].'</td>
			<td>'.$values['firstname'].'</td>
			<td>'.$values['lastname'].'</td>
			<td>'.$values['username'].'</td>
			<td>'.$values['active'].'</td>
			<td>Administrator</td>
			<td><a
				href="'.$_SERVER['PHP_SELF'].'?uri=useredit&id='.$values['id'].'">Bearbeiten</a>
				&middot; <a
				href="'.$_SERVER['PHP_SELF'].'?uri=userdel&id='.$values['id'].'">Löschen</a></td>
		</tr>
	</tbody>
</table>
<a href="$_SERVER['PHP_SELF']?uri=useradd" class="btn btn-primary" role="button">Anlegen</a>