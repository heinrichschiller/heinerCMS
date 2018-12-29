<?php

namespace Controller;

class InstallerController extends Base
{
    public function indexAction()
    {
        echo $this->render('start.phtml');
    }

    public function languageAction()
    {
        echo $this->render('language.phtml');
    }

    public function licenceAction()
    {
        echo $this->render('licence.phtml');
    }

    public function conditionsAction()
    {
        echo $this->render('conditions.phtml');
    }

    public function databaseAction()
    {
        echo $this->render('database.phtml');
    }
}
