<?php

namespace Adminka\Controllers;

use Adminka\Core\Mvc\ControllerWeb;
use Dez\Html\Element\AElement;

class IndexController extends ControllerWeb {

    public function indexAction()
    {
        $a = new AElement('https://github.com/dez-php/adminka', 'Adminka', [
            'target' => '_blank',
            'class' => 'light-link'
        ]);
        $this->flash->success("Welcome to {$a}!");
        $this->redirect('index/welcome');
    }

    public function welcomeAction()
    {

    }

}