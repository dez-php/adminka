<?php

namespace Shopper\Controllers;

use Dez\Mvc\Controller;

class IndexController extends Controller {

    public function welcomeAction()
    {
        $this->setLayout('index');
        return $this->view->fetch('shopper::index/product_data', [
            'id' => __METHOD__
        ]);
    }

    public function indexAction()
    {
//        $this->setLayout('index');

        return $this->view->render('sq::index/index');
    }

    public function productDataAction($id = 0)
    {
        $this->setLayout('index');

        return $this->view->fetch('max_shop::index/product_data', [
            'id' => $id
        ]);
    }

    public function orderAction()
    {
        $this->setLayout('sq::index');

        return $this->view->fetch('max_shop::index/product_data', [
            'id' => __METHOD__
        ]);
    }

}