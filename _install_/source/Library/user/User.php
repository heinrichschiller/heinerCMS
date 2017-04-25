<?php

class User {

	private $_link = null;
	private $_firstname = '';
	private $_lastname = '';
	private $_email = '';
	private $_username = '';
	private $_password = '';
	
	public function __construct(Mysqli $adapter, Array $user_data) {
		$this->_setLink($adapter);
		
		$this->_setFirstname($user_data['firstname']);
		$this->_setLastname($user_data['lastname']);
		$this->_setEmail($user_data['email']);
		$this->_setUsername($user_data['username']);
		$this->_setPassword($user_data['password1'], $user_data['password2']);
	}

	private function _setLink($link) {
		$this->_link = $link;
	}

	private function _setFirstname($firstname) {
		$this->_firstname = $firstname;
	}

	private function _setLastname($lastname) {
		$this->_lastname = $lastname;
	}

	private function _setEmail($email) {
		$this->_email = $email;
	}

	private function _setUsername($username) {
		$this->_username = $username;
	}

	private function _setPassword($password1, $password2) {
		if ( strcmp($password1, $password2) === 0) {
			$this->_password = $password1;
		} else {
			$this->_password = '';
		}
	}

	private function _getFirstname() {
		return $this->_firstname;
	}

	private function _getLastname() {
		return $this->_lastname;
	}

	private function _getEmail() {
		return $this->_email;
	}

	private function _getUsername() {
		return $this->_username();
	}

	private function _getPassword() {
		return $this->_password;
	}

	public function create() {
		$firstname = $this->_firstname;
		$lastname = $this->_lastname;
		$email = $this->_email;
		$username = $this->_username;
		$password = password_hash($this->_password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (firstname,lastname,email,username,password,active) 
			VALUES ('$firstname','$lastname','$email','$username','$password',true);";

		$this->_link->query($sql);
	}
}





