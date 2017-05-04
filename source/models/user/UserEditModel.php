<?php

class UserEditModel
{
    /**
     * Database adapter
     * 
     * @var null
     */
    private $_pdo = null;

    /**
     * User
     * 
     * @var string
     */
    private $_user = '';
    
    public function __construct(PDO $pdo)
    {
        $this->_pdo = $pdo;
    }

    /**
     * Load a user from database
     * 
     * @param string $id - Id from an user
     * @return array
     */
    public function load($id)
    {
        $sql = 'SELECT `id`,`firstname`,`lastname`,`email`,`password`,`created_at`,`updated_at`,`username`,`active`'
            . ' FROM `users`'
            . "WHERE `id` = ?";

        $stmt = $this->_pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}