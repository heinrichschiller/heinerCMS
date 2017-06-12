<div class="container-fluid">
    <div class="row">
    	<div class="col-lg-12 col-md-10 col-sm-10 col-12">
    		<div class="panel">
    			<h4><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash</h4>
    		</div>
    	</div>
    </div>
	<div class="row">
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">News</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="newsdel.php">
    					<table class="table table-hover table-striped">
    						<thead>
    							<tr>
    								<th></th>
        							<th>#</th>
        							<th>Datum</th>
        							<th>Titel</th>
        							<th>Aktionen</th>
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
                    		<button type="submit" class="btn btn-danger" name="action" value="del_newsList">Auswahl löschen</button>
                    		<span></span>
                    		<button type="submit" class="btn btn-danger" name="action" value="del_all">Alle löschen</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Downloads</h3>
				</div>
				<div class="panel-body">
    				<form method="post" action="downloadsdel.php">
        				<table class="table table-hover table-striped">
        						<thead>
        							<tr>
        								<td></td>
            							<th>#</th>
            							<th>Datum</th>
            							<th>Titel</th>
            							<th>Aktionen</th>
            						</tr>
        						</thead>
        						<tbody>
        						<?php foreach ($result[1] as $downloads) :?>
        						<tr>
        							<td><input type="checkbox" name="chk_select[]" value="<?= $downloads['id'];?>"></td>
        							<td><?= $downloads['id'];?></td>
        							<td><?= strftime('%d.%m.%Y', $downloads['datetime']); ?></td>
        							<td><?= $downloads['title'];?></td>
        							<td>...</td>
        						</tr>
        						<?php endforeach;?>
        						</tbody>
        				</table>
        				<div class="form-group">
                       		<button type="submit" class="btn btn-danger" name="action" value="del_downloadsList">Auswahl löschen</button>
                       		<span></span>
                       		<button type="submit" class="btn btn-danger" name="action" value="del_all">Alle löschen</button>
                       	</div>
        			</form>
			</div>
		</div>
	</div>
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Links</h3>
				</div>
				<div class="panel-body">
    				<form method="post" action="linkdel.php">
    					<table class="table table-hover table-striped">
    						<thead>
    							<tr>
    								<td></td>
        							<th>#</th>
        							<th>Datum</th>
        							<th>Titel</th>
        							<th>Aktionen</th>
        						</tr>
    						</thead>
    						<tbody>
    						<?php foreach ($result[2] as $link) :?>
    						<tr>
    							<td><input type="checkbox" name="chk_select[]" value="<?= $link['id'];?>"></td>
    							<td><?= $link['id'];?></td>
    							<td><?= strftime('%d.%m.%Y', $link['datetime']); ?></td>
    							<td><?= $link['title'];?></td>
    							<td>...</td>
    						</tr>
    						<?php endforeach;?>
    						</tbody>
    					</table>
        				<div class="form-group">
                       		<button type="submit" class="btn btn-danger" name="action" value="del_linkList">Auswahl löschen</button>
                       		<span></span>
                       		<button type="submit" class="btn btn-danger" name="action" value="del_all">Alle löschen</button>
                       	</div>
    				</form>
    			</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-4 col-sm-5 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Articles</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="articledel.php">
        				<table class="table table-hover table-striped">
        					<thead>
        						<tr>
        							<td></td>
            						<th>#</th>
            						<th>Datum</th>
           							<th>Titel</th>
           							<th>Aktionen</th>
           						</tr>
       						</thead>
       						<tbody>
       						<?php foreach ($result[3] as $article) :?>
       						<tr>
       							<td><input type="checkbox" name="chk_select[]" value="<?= $article['id']; ?>"></td>
       							<td><?= $article['id'];?></td>
        						<td><?= strftime('%d.%m.%Y', $article['datetime']); ?></td>
        						<td><?= $article['title'];?></td>
        						<td>...</td>
       						</tr>
       						<?php endforeach;?>
       						</tbody>
        				</table>
    					<div class="form-group">
                    		<button type="submit" class="btn btn-danger" name="action" value="del_articlesList">Auswahl löschen</button>
                    		<span></span>
                    		<button type="submit" class="btn btn-danger" name="action" value="del_all">Alle löschen</button>
                    	</div>
    				</form>
    			</div>
			</div>
		</div>
	</div>
</div>