<?php

namespace Shopper\Controllers;

use Shopper\Core\Mvc\ControllerWeb;

class ProductsController extends ControllerWeb {

    public function indexAction()
    {
        $this->setLayout('index');
        return __METHOD__;
    }

}