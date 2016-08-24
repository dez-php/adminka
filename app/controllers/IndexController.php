<?php

namespace Adminka\Controllers;

use Adminka\Core\Mvc\ControllerWeb;

class IndexController extends ControllerWeb {

    public function indexAction()
    {
        $this->view->set('file', __FILE__);
    }

}