<?php

namespace Adminka\Controllers;

use Adminka\Core\Mvc\ControllerWeb;

class IndexController extends ControllerWeb {

    public function indexAction()
    {
        $this->flash->success("Welcome to Adminka!");
//        $this->redirect('index/welcome');
    }

    public function welcomeAction()
    {

    }

}