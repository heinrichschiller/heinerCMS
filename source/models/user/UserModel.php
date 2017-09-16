<?php

class UserModel
{
    /**
     * ID of the person
     * 
     * @var string
     */
    private $_id = '';
    
    /**
     * Firstname of the person
     * 
     * @var string
     */
    private $_firstname = '';
    
    /**
     * Lastname of the person
     * 
     * @var string
     */
    private $_lastname = '';
    
    /**
     * Email of the person
     * 
     * @var string
     */
    private $_email = '';
    
    /**
     * Created time of the entry of the person
     * 
     * @var string
     */
    private $_createdAt = '';
    
    /**
     * Update time of the entry of the person
     * 
     * @var string
     */
    private $_updatedAt = '';
    
    /**
     * Username (login) of the person
     * 
     * @var string
     */
    private $_username = '';
    
    /**
     * Displays is the user active or inactive in the database.
     * If the user is active (true), he can login into the database,
     * else if the user is inactive (false) he can not login into
     * the database.
     * 
     * @var string
     */
    private $_isActive = false;
    
    public function __construct()
    {
        // put your code here if needed
    }
    
    /**
     * 
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * 
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }
    
    /**
     * 
     * @return string
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }
    
    /**
     * 
     * @param string $firstname
     */
    public function setFirstname(string $firstname)
    {
        $this->_firstname = $firstname;
    }
    
    /**
     * 
     * @return string
     */
    public function getLastname()
    {
        return $this->_lastname;
    }
    
    /**
     * 
     * @param string $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->_lastname = $lastname;
    }
    
    /**
     * 
     */
    public function getEmail()
    {
        
    }
    
    /**
     * 
     * @param string $email
     */
    public function setEmail(string $email)
    {
        
    }
    
    /**
     * 
     */
    public function getCreatedAt()
    {
        
    }
    
    /**
     * 
     * @param string $data
     */
    public function setCreatedAt(string $data)
    {
        
    }
    
    /**
     * 
     */
    public function getUpdatedAt()
    {
        
    }
    
    /**
     * 
     * @param string $data
     */
    public function setUpdatedAt(string $data)
    {
        
    }
    
    /**
     * 
     */
    public function getUsername()
    {
        
    }
    
    /**
     * 
     * @param string $username
     */
    public function setUsername(string $username)
    {
        
    }
    
    /**
     * Get the activity of the user
     * 
     * @return string
     */
    public function getActivity()
    {
        return $this->_isActive;
    }
    
    /**
     * Set the activity of the user
     * 
     * @param bool $isActive User can be active(true) or inactive(false)
     */
    public function setActivity(bool $isActive)
    {
        $this->_isActive = $isActive;
    }
}