<?php

namespace SurveyQuality\Controllers;

use Dez\Mvc\Controller;

class IndexController extends Controller {

    public function indexAction()
    {
        $this->setLayout('index');
        return $this->getReflectionClass()->getFileName();
    }

}