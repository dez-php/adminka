<?php

namespace SurveyQuality;

use Adminka\Core\InjectableAware;
use Adminka\Core\Module\ModuleInitializerInterface;
use Dez\Config\Config;

class Initializer extends InjectableAware implements ModuleInitializerInterface {

    public function initialize()
    {
        $this->config->merge(Config::factory([]));

        $this->loader->registerNamespaces([
            __NAMESPACE__ . '\\Controllers' => __DIR__ . '/controllers'
        ])->register();

        $this->router->add('/survey_quality', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/survey_quality/:action', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/survey_quality/:controller/:action', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/survey_quality/:controller/:action/:id', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/survey_quality/:id', [
            'namespace' => __NAMESPACE__ . '\\Controllers',
            'controller' => 'product',
            'action' => 'item',
        ]);

        $this->view->addDirectory('sq', __DIR__ . '/templates');
    }

}

return new Initializer();