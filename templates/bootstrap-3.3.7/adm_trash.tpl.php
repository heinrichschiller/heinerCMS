<div class="container-fluid">
    <div class="row">
    	<div class="col-lg-12 col-md-10 col-sm-10 col-12">
    		<div class="panel">
    			<h4><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {trash}</h4>
    		</div>
    	</div>
    </div>
	<div class="row">
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{news}</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="newsdel.php">
    					<table class="table table-hover table-striped">
    						<thead>
    							<tr>
    								<th></th>
        							<th>#</th>
        							<th>{date}</th>
        							<th>{title}</th>
        							<th>{actions}</th>
        						</tr>
    						</thead>
    						<tbody>
    						<?php foreach ($result[0] as $news) :?>
    						<tr>
    							<td><input type="checkbox" name="chk_select[]" value="<?= $news['id']; ?>"></td>
    							<td><?= $news['id'];?></td>
    							<td><?= strftime('%d.%m.%Y', $news['datetime']); ?></td>
    							<td><?= $news['title'];?></td>
    							<td>...</td>
    						</tr>
    						<?php endforeach;?>
    						</tbody>
    					</table>
    					<div class="form-group">
                    		<button type="submit" class="btn btn-danger" name="action" value="del">{clear_selection}</button>
                    		<span></span>
                    		<button type="submit" class="btn btn-danger" name="action" value="del_all">{clear_all}</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{downloads}</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="downloadsdel.php">
    					<table class="table table-hover table-striped">
    						<thead>
    							<tr>
    								<th></th>
        							<th>#</th>
        							<th>{date}</th>
        							<th>{title}</th>
        							<th>{actions}</th>
        						</tr>
    						</thead>
    						<tbody>
    						<?php foreach ($result[1] as $download) :?>
    						<tr>
    							<td><input type="checkbox" name="chk_select[]" value="<?= $download['id']; ?>"></td>
    							<td><?= $download['id'];?></td>
    							<td><?= strftime('%d.%m.%Y', $download['datetime']); ?></td>
    							<td><?= $download['title'];?></td>
    							<td>...</td>
    						</tr>
    						<?php endforeach;?>
    						</tbody>
    					</table>
    					<div class="form-group">
                    		<button type="submit" class="btn btn-danger" name="action" value="del">{clear_selection}</button>
                    		<span></span>
                    		<button type="submit" class="btn btn-danger" name="action" value="del_all">{clear_all}</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{links}</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="linkdel.php">
    					<table class="table table-hover table-striped">
    						<thead>
    							<tr>
    								<th></th>
        							<th>#</th>
        							<th>{date}</th>
        							<th>{title}</th>
        							<th>{actions}</th>
        						</tr>
    						</thead>
    						<tbody>
    						<?php foreach ($result[2] as $link) :?>
    						<tr>
    							<td><input type="checkbox" name="chk_select[]" value="<?= $link['id']; ?>"></td>
    							<td><?= $link['id'];?></td>
    							<td><?= strftime('%d.%m.%Y', $link['datetime']); ?></td>
    							<td><?= $link['title'];?></td>
    							<td>...</td>
    						</tr>
    						<?php endforeach;?>
    						</tbody>
    					</table>
    					<div class="form-group">
                    		<button type="submit" class="btn btn-danger" name="action" value="del">{clear_selection}</button>
                    		<span></span>
                    		<button type="submit" class="btn btn-danger" name="action" value="del_all">{clear_all}</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{articles}</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="articledel.php">
    					<table class="table table-hover table-striped">
    						<thead>
    							<tr>
    								<th></th>
        							<th>#</th>
        							<th>{date}</th>
        							<th>{title}</th>
        							<th>{actions}</th>
        						</tr>
    						</thead>
    						<tbody>
    						<?php foreach ($result[3] as $news) :?>
    						<tr>
    							<td><input type="checkbox" name="chk_select[]" value="<?= $news['id']; ?>"></td>
    							<td><?= $news['id'];?></td>
    							<td><?= strftime('%d.%m.%Y', $news['datetime']); ?></td>
    							<td><?= $news['title'];?></td>
    							<td>...</td>
    						</tr>
    						<?php endforeach;?>
    						</tbody>
    					</table>
    					<div class="form-group">
                    		<button type="submit" class="btn btn-danger" name="action" value="del">{clear_selection}</button>
                    		<span></span>
                    		<button type="submit" class="btn btn-danger" name="action" value="del_all">{clear_all}</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>