<h4>{settings}</h4>


<form action="general_settings.php" method="post">
	<table>
		<tr>
			<td>
				<label for="title">{title}:</label>
			</td>
			<td>
				<input type="text" name="title" value="<?= $_SESSION['title']; ?>">
			</td>
		</tr>
		<tr>
			<td>
				<label for="sel1">Themes:</label>
			</td>
			<td>
				<select class="form-control" name="theme">
                  <?php foreach ($result as $theme) :?>
             		   <option><?= $theme;?></option>
             	 <?php endforeach;?>
                  </select>
            </td>
		</tr>
		<tr>
			<td>
				<button type="submit">{save}</button>
			</td>
			<td>
				<button type="reset">{reset}</button>
			</td>
		</tr>
	</table>
</form>
