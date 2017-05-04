<?php

class Db_Adapter {

	private $_pdo = null;
	private $_hostName = '';
	private $_userName = '';
	private $_password = '';
	private $_database = '';
	
	public function __construct(Array $ini_array) {
		$this->_hostName = $ini_array['host'];
		$this->_userName = $ini_array['user'];
		$this->_password = $ini_array['password'];
	}
	
	public function init()
	{
	    $host = $this->_hostName;
	    $user = $this->_userName;
	    $password = $this->_password;
	    $database = $this->_database;

        try {
            $this->_pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        } catch (PDOException $ex) {
            printf("Error! %s", $ex->getMessage());
        }

	}

	public function getAdapter() {
		return $this->_pdo;
	}
	
}