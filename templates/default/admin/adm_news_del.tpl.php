<form action="newsdel.php" method="post">
	<p>
		Möchten Sie die Nachricht <strong>##placeholder-title##</strong> wirklich löschen?
	</p>
	<p>
		<input type="submit" value="Ja">
		<input type="reset" value="Nein" onClick="location.href = 'index.php?uri=articles'">
	</p>
	<input type="hidden" name="id" value="##placeholder-id##">
</form>