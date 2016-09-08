<?php

namespace SystemUtils\Controllers;

use Dez\Mvc\Controller;

class StringController extends Controller {

    public function indexAction()
    {
        $this->setLayout('index');
        return $this->view->render('index/index');
    }

}