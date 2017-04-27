<?php

class Db_Adapter {

	private $_link = null;
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
		$this->_link = new mysqli($this->_hostName,
			$this->_userName,
			$this->_password);
		
		if ($this->_link->connect_errno) {
			printf("Connect failed: %s\n", $this->_link->connect_error());
			exit ();
		}
	}

	public function getAdapter() {
		return $this->_link;
	}
	
}