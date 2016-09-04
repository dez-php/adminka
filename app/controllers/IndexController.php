<?php

namespace Adminka\Controllers;

use Adminka\Core\Mvc\ControllerWeb;

class IndexController extends ControllerWeb {

    public function indexAction()
    {
        $this->flash->success("Welcome to Adminka!");
//        $this->setLayout(null);
//        return $this->view->render('shop::index/index');
//        $this->redirect('index/welcome');
    }

    public function welcomeAction()
    {

    }

}