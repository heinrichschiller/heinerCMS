<?php

class User {

	/**
	 * Database adapter
	 * 
	 * @var null
	 */
	private $_link = null;

	/**
	 * Firstname of a user
	 * 
	 * @var string
	 */
	private $_firstname = '';

	/**
	 * Lastname of a user
	 * @var string
	 */
	private $_lastname = '';

	/**
	 * Email of a user
	 * 
	 * @var string
	 */
	private $_email = '';

	/**
	 * Username of a user
	 * 
	 * @var string
	 */
	private $_username = '';

	/**
	 * Password of a user
	 * @var string
	 */
	private $_password = '';
	
	public function __construct(Mysqli $adapter)
	{
		$this->_link = $adapter;
	}

	/**
	 * Set the firstname of a user
	 * 
	 * @param string $firstname - Firstname of a user
	 */
	public function setFirstname($firstname)
	{
		$this->_firstname = $firstname;
	}

	/**
	 * Set the lastname of a user
	 * 
	 * @param string $lastname - Lastname of a user
	 */
	public function setLastname($lastname)
	{
		$this->_lastname = $lastname;
	}

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
	 * Set the username of a user
	 * 
	 * @param string $username - Username of a user
	 */
	public function setUsername($username)
	{
		$this->_username = $username;
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
	 * Return the firstname of a user
	 * 
	 * @return string
	 */
	public function getFirstname()
	{
		return $this->_firstname;
	}

	/**
	 * Return the lastname of a user
	 * 
	 * @return string
	 */
	public function getLastname()
	{
		return $this->_lastname;
	}

	/**
	 * Return the email of a user
	 * 
	 * @return string
	 */
	public function getEmail()
	{
		return $this->_email;
	}

	/**
	 * Return the username of a user
	 * 
	 * @return string
	 */
	public function getUsername()
	{
		return $this->_username;
	}

	/**
	 * Return the password of a user
	 * 
	 * @return string
	 */
	public function getPassword()
	{
		return $this->_password;
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

		$this->_link->query($sql);
	}
}





