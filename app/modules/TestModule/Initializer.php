<?php

namespace TestModule;

use Adminka\Core\InjectableAware;
use Adminka\Core\ModuleInterface;
use Dez\Config\Config;

class Initializer extends InjectableAware implements ModuleInterface{

    public function initialize()
    {
        $this->config->merge(Config::factory([
            'modules' => [
                'shop' => [
                    'pages' => 123
                ]
            ]
        ]));

        $this->loader->registerNamespaces([
            __NAMESPACE__ . '\\Controllers' => __DIR__ . '/controllers'
        ])->register();

        $this->router->add('shop/:controller/:action', [

        ]);

    }

}

(new Initializer())->setDi($di)->initialize();