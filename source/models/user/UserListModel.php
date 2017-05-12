<?php

class UserListModel
{
	private $_pdo = null;

	public function __construct(PDO $pdo)
	{
		$this->_pdo = $pdo;
	}

	public function listAll()
	{
		$sql = 'SELECT `id`,`firstname`,`lastname`,`username`,`active`'
			. ' FROM `users` ORDER BY `firstname` DESC';

		$stmt = $this->_pdo->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll();
	}
}