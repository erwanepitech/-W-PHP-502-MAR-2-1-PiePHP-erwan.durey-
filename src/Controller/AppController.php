<?php

namespace src\Controller;

class AppController extends \Core\Controller
{

    public function __construct()
    {
        $this->request = new \Core\Request();
    }

    public function IndexAction()
    {
        $this->render('index');
    }

    public function ErrorAction () {
        $this->render('404');
    }
}
