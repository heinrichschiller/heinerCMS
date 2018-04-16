<form action="userdel.php" method="post">
	<p>
		Möchten Sie den {user} <b><@title@></b> wirklich löschen?
	</p>
	<p>
		<input type="submit" value="Ja">
		<input type="reset" value="Nein" onClick="location.href = 'index.php?uri=user'">
	</p>
	<input type="hidden" name="id" value="<@id@>">
</form>