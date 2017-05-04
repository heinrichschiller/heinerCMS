<?php

class UserEditController
{
    private $_model = null;

    public function __construct(UserEditModel $model)
    {
        $this->_model = $model;
    }

}