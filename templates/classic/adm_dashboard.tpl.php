<div>
	<h4>{dashboard}</h4>
</div>
<div>
	<h3>{news}</h3>
</div>
<div>
	<table>
		<tr>
			<th>#</th>
			<th>{date}</th>
			<th>{title}</th>
			<th>{visible}</th>
		</tr>
		<tr>
			<td>
				<@news_content@>
			<td>
		</tr>
	</table>
	<div>
		<a href="?uri=newsadd">{create}</a>
	</div>
</div>
<div>
			<h3>{downloads}</h3>
		</div>
		<div>
			<table>

					<tr>
						<th>#</th>
						<th>{date}</th>
						<th>{title}</th>
						<th>{visible}</th>
					</tr>

				<tbody>
				<@downloads_content@>
				</tbody>
			</table>
		</div>
		<div class="panel-body">
			<a href="?uri=downloadsadd">{create}</a>
		</div>
	</div>
</div>
</div>
<div class="row">
	<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{links}</h3>
			</div>
			<div class="panel-body">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>{date}</th>
							<th>{title}</th>
							<th>{visible}</th>
						</tr>
					</thead>
					<tbody><@links_content@>
					</tbody>
				</table>
			</div>
			<div class="panel-body">
				<a href="?uri=linkadd">{create}</a>
			</div>
		</div>
	</div>
	<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{article}</h3>
			</div>
			<div class="panel-body">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>{date}</th>
							<th>{title}</th>
							<th>{visible}</th>
						</tr>
					</thead>
					<tbody><@articles_content@>
					</tbody>
				</table>
			</div>
			<div class="panel-body">
				<a href="?uri=articlesadd">{create}</a>
			</div>
		</div>
	</div>
</div>
</div>