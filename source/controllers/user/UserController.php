<?php

class UserController {

    private $_pdo = null;
    private $_model = null;
    
    public function __construct(PDO $pdo, UserModel $model)
    {
        $this->_pdo = $pdo;
        $this->_model = $model;
    }
    


	/**
	 * Create the database entry of a user
	 */
	public function create()
	{
		$password = password_hash($this->_model->getPassword(), PASSWORD_DEFAULT);

		$sql = 'INSERT INTO `users` (`firstname`, `lastname`, `email`, `username`, `password`, `active`) '
            . "VALUES ('" . $this->_model->getFirstname() . "'"
            . ",'" . $this->_model->getLastname() . "'"
            . ",'" . $this->_model->getEmail() . "'"
            . ",'" . $this->_model->getUsername() . "'"
            . ",'$password',true)";

        try {
            $this->_pdo->exec($sql);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }
		
	}
}





