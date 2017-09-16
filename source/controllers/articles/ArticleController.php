<?php

class ArticleController
{
    /**
     * MySQL connector
     * 
     * @var object Mysql object
     */
    private $_connector = null;
    
    /**
     * Object of the ArticleModel
     * 
     * @var object
     */
    private $_model = null;
    
    public function __construct(MySQLi $con, ArticleModel $model)
    {
        $this->_connector = $con;
        $this->_model = $model;
    }
    
    public function add()
    {
        $sql = "INSERT INTO `articles` (`title`, `content`, `visible`)"
            . " VALUES ('".$this->_model->getTitle()."','".$this->_model->getContent()."',".$this->_model->getVisible().")";

        mysqli_query ( $this->_connector, $sql );
        mysqli_close( $this->_connector );
    }
}