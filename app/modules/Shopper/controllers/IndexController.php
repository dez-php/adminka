<?php

namespace Shopper\Controllers;

use Shopper\Core\Mvc\ControllerWeb;

class IndexController extends ControllerWeb {

    public function welcomeAction()
    {
//        $this->setLayout('index');
        $this->view->set('id', __FILE__);
    }

    public function indexAction()
    {

    }

    public function productDataAction($id = 0)
    {

    }

    public function orderAction()
    {
        $this->setLayout('sq::index');

        return $this->view->fetch('max_shop::index/product_data', [
            'id' => __METHOD__
        ]);
    }

}