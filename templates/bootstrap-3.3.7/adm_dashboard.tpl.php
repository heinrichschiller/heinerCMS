<div class="container-fluid">
    <div class="row">
    	<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
    		<div class="panel">
    			<h4><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> {dashboard}</h4>
    		</div>
    	</div>
    </div>
	<div class="row">
		<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{news}</h3>
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
						<tbody>
						<?php foreach ($result[0] as $news) :?>
						<tr>
							<td><?= $news['id'];?></td>
							<td><?= strftime('%d.%m.%Y', $news['datetime']); ?></td>
							<td><?= $news['title'];?></td>
							<td><?= ($news['visible'] > -1) ? ' ja' : ' nein'; ?></td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<div class="panel-body"><a href="?uri=newsadd">{create}</a></div>
			</div>
		</div>
		<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{downloads}</h3>
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
						<tbody>
						<?php foreach ($result[1] as $downloads) :?>
						<tr>
							<td><?= $downloads['id'];?></td>
							<td><?= strftime('%d.%m.%Y', $downloads['datetime']); ?></td>
							<td><?= $downloads['title'];?></td>
							<td><?= ($downloads['visible'] > -1) ? ' ja' : ' nein'; ?></td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				</div>
				<div class="panel-body"><a href="?uri=downloadsadd">{create}</a></div>
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
						<tbody>
						<?php foreach ($result[2] as $link) :?>
						<tr>
							<td><?= $link['id'];?></td>
							<td><?= strftime('%d.%m.%Y', $link['datetime']); ?></td>
							<td><?= $link['title'];?></td>
							<td><?= ($link['visible'] > -1) ? ' ja' : ' nein'; ?></td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table></div>
				<div class="panel-body"><a href="?uri=linkadd">{create}</a></div>
			</div>
		</div>
		<div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{article}</h3>
				</div>
				<div class="panel-body"><table class="table table-hover table-striped">
						<thead>
							<tr>
    							<th>#</th>
    							<th>{date}</th>
    							<th>{title}</th>
    							<th>{visible}</th>
    						</tr>
						</thead>
						<tbody>
						<?php foreach ($result[3] as $article) :?>
						<tr>
							<td><?= $article['id'];?></td>
							<td><?= strftime('%d.%m.%Y', $article['datetime']); ?></td>
							<td><?= $article['title'];?></td>
							<td><?= ($article['visible'] > -1) ? ' ja' : ' nein'; ?></td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table></div>
				<div class="panel-body"><a href="?uri=articlesadd">{create}</a></div>
			</div>
		</div>
	</div>
</div>