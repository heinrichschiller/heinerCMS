<form action="newsinsert.php" method="post">
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<th>Titel:</th>
			<td><input type="text" name="title" size="64"></td>
		</tr>
		<tr>
			<th>Datum:</th>
			<td><?= $result; ?></td>
		</tr>
		<tr>
			<th>Text:</th>
			<td><textarea name="message" cols="64" rows="16"></textarea></td>
		</tr>
		<tr>
			<th>Sichtbar?</th>
			<td><input type="radio" name="visible" value="0" checked> ja <input
				type="radio" name="visible" value="-1"> nein</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Speichern"> <input
				type="reset" value="Zurücksetzen"></td>
		</tr>
	</table>
</form>