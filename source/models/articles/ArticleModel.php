<?php

class ArticleModel
{
    /**
     * Id of an article
     * 
     * @var integer
     */
    private $_id = '';
    
    /**
     * Title of a article
     * 
     * @var string
     */
    private $_title = '';
    
    /**
     * Content of a article
     * @var string
     */
    private $_content = '';
    
    /**
     * Creation time of an article
     * 
     * @var string
     */
    private $_createdAt = '';
    
    /**
     * Update time of an article
     * 
     * @var string
     */
    private $_updatedAt = '';
    
    /**
     * Id from next id of a page
     * 
     * @var integer
     */
    private $_nextPageId = 0;
    
    /**
     * Visibility of an article
     * 
     * @var integer
     */
    private $_visible = 0;
    
    /**
     * Is an article trash or not
     * 
     * @var integer
     */
    private $_trashId = 0;
    
    public function __construct()
    {
        // put your code here if needed
    }
    
    /**
     * Get id of the article
     * 
     * @return number Id of the article
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set id of the article
     * 
     * @param string $id Id of the article
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }
    
    /**
     * Get title of the article
     * 
     * @return string Title of the article
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Set title of the article
     * 
     * @param string $title Title of the article
     */
    public function setTitle(string $title)
    {
        $this->_title = $title;
    }
    
    /**
     * Get content of the article
     * 
     * @return string Content of the article
     */
    public function getContent()
    {
        return $this->_content;
    }
    
    /**
     * Set content for the article
     * 
     * @param string $content Content of the article
     */
    public function setContent(string $content)
    {
        $this->_content = $content;
    }
    
    /**
     * Get the creation time of the article
     * 
     * @return string Creation time of the article
     */
    public function getCreatedAt()
    {
        return $this->_createAt;
    }
    
    /**
     * Set the creation time of the article
     * 
     * @param string $date Creation time of the article
     */
    public function setCreatedAt(string $date)
    {
        $this->_createAt = $date;
    }
    
    /**
     * Get the update time of the article
     * 
     * @return string Update time of the article
     */
    public function getUpdatedAt()
    {
        return $this->_updatedAt;
    }
    
    /**
     * Set the update time of the article
     * 
     * @param string $date Update time of the article
     */
    public function setUpdatetAt(string $date)
    {
        $this->_nextPageId = $date;
    }
    
    /**
     * Get id for the next page in an article
     * 
     * @return number Next page id of the article
     */
    public function getNextPageId()
    {
        return $this->_nextPageId;
    }
    
    /**
     * Set id for the next page in an article
     * 
     * @param int $pageId Next page id of the article
     */
    public function setNextPageId(int $pageId)
    {
        $this->_nextPageId = $pageId;
    }
    
    /**
     * Get state of the visibility of the article
     * 
     * @return number State of the visibility of the article
     */
    public function getVisible()
    {
        return $this->_visible;
    }
    
    /**
     * Set state of the visibility
     * 
     * @param string $isVisible State of the visibility of the article
     */
    public function setVisible(string $isVisible)
    {
        $this->_visible = $isVisible;
    }
    
    /**
     * Get trash id of the article
     * 
     * @return number Trash id of the article
     */
    public function getTrashId()
    {
        return $this->_trashId;
    }
    
    /**
     * Set trash id of the article
     * 
     * @param int $trashId Trash id of the article
     */
    public function setTrashId(int $trashId)
    {
        $this->_trashId = $trashId;
    }
    
}