<?php

namespace Shopper\Core\Mvc;

use Dez\Mvc\Controller;

class ControllerWeb extends Controller {

    const MODULE_NAME = 'shopper';

    public function beforeExecute()
    {
        parent::beforeExecute();

        $this->setPseudoPath(static::MODULE_NAME);
    }

    public function afterExecute()
    {
        parent::afterExecute();
    }

    public function render($path, array $data = [])
    {
        return $this->view->fetch($path, $data);
    }


}