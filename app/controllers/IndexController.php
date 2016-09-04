<?php

namespace Adminka\Controllers;

use Adminka\Core\Mvc\ControllerWeb;
use Dez\Http\Response;

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

    public function dumpConfigAction()
    {
        $this->setLayout(null);
        $this->response->setBodyFormat(Response::RESPONSE_RAW);
        $this->response->setContentType(Response::CONTENT_PLAIN);
        return $this->config->toString();
    }

    public function dumpRoutesAction()
    {
        $this->setLayout(null);
        $this->response->setBodyFormat(Response::RESPONSE_JSON);

        $routes = [];

        foreach($this->router->getRoutes() as $route) {
            $routes[] = $route->getPseudoPattern();
        }

        return $routes;
    }

}