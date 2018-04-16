<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-12">
		<div class="panel">
			<h4>
				<img class="glyph-icon-24" src="../templates/default/admin/img/svg/si-glyph-person-people.svg">
				{user}
			</h4>
		</div>
	</div>
</div>
<table class="table table-hover table-striped">
    <thead>
        <th>#</th>
        <th>{firstname}</th>
        <th>{lastname}</th>
        <th>{username}</th>
        <th>{active}</th>
        <!-- <th>Role</th>  -->
        <th>{actions}</th>
    </thead>
    <tbody>
			##placeholder-user-list-content##
	</tbody>
</table>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<a href="index.php?uri=userinsert" class="btn btn-primary" role="button">{create_user}</a>
	</div>	
</div>