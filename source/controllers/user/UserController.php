<?php

class UserController {

	/**
	 * Set the email of a user
	 * 
	 * @param string $email - Email of a user
	 */
	public function setEmail($email)
	{
		$this->_email = filter_var($email, FILTER_VALIDATE_EMAIL);
	}



	/**
	 * Set the password if values ​​are equal, otherwise the password is empty
	 * 
	 * @param string $password1 - Password 1
	 * @param string $password2 - Password 2
	 */
	public function setPassword($password1, $password2)
	{
    	if ( strcmp($password1, $password2) === 0) {
    	    $this->_password = $password1;
    	} else {
    	    $this->_password = '';
    	}
	}

	/**
	 * Fetch all user data
	 * 
	 * @param array $user_data - Array contains all data from a user
	 */
	public function fetchAll(Array $user_data)
	{
		$this->_firstname = $user_data['firstname'];
		$this->_lastname = $user_data['lastname'];
		$this->_email = $user_data['email'];
		$this->_username = $user_data['username'];
		self::setPassword($user_data['password1'], $user_data['password2']);
	}

	/**
	 * Create the database entry of a user
	 */
	public function create()
	{
		$password = password_hash($this->_password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO `users` (`firstname`, `lastname`, `email`, `username`, `password`, `active`) 
		VALUES ('$this->_firstname','$this->_lastname','$this->_email','$this->_username','$password',true);";

		$this->_pdo->query($sql);
	}
}





