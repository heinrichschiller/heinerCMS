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
        <th>#</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Username</th>
        <th>Aktiv</th>
        <!-- <th>Role</th>  -->
        <th>Aktion</th>
    </thead>
    <tbody>
			<@user_list_content@>
	</tbody>
</table>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<a href="$PHP_SELF?uri=userinsert" class="btn btn-primary" role="button">Benutzer anlegen</a>
	</div>	
</div>