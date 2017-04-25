<?php

class Db_Adapter {

	private $_link = null;
	private $_hostName = '';
	private $_userName = '';
	private $_password = '';
	private $_database = '';
	
	public function __construct(Array $ini_array) {
		$this->_setHostname($ini_array['host']);
		$this->_setUsername($ini_array['user']);
		$this->_setPassword($ini_array['password']);
		$this->_setDatabase($ini_array['database']);
	}
	
	private function _setHostname($hostname) {
		$this->_hostName = $hostname;
	}
	
	private function _setUsername($username) {
		$this->_userName = $username;
	}
	
	private function _setPassword($password) {
		$this->_password = $password;
	}
	
	private function _setDatabase($database) {
		$this->_database = $database;
	}
	
	private function _getHostname() {
		return $this->_hostName;
	}
	
	private function _getUsername() {
		return $this->_userName;
	}
	
	private function _getPassword() {
		return $this->_password;
	}
	
	private function _getDatabase() {
		return $this->_database;
	}
	
	public function init() {
		$hostname = $this->_getHostname();
		$username = $this->_getUsername();
		$password = $this->_getPassword();
		$database = $this->_getDatabase();
		
		$this->_link = new mysqli($hostname,$username,$password,$database);
		
		if ($this->_link->connect_errno) {
			printf("Connect failed: %s\n", $this->_link->connect_error());
			exit ();
		}
	}

	public function getAdapter() {
		return $this->_link;
	}
	
}