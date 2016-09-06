<?php

namespace Shopper;

use Adminka\Core\InjectableAware;
use Adminka\Core\Module\ModuleInitializerInterface;
use Dez\Config\Config;

/**
 * Class Initializer
 * @package Shopper
 */
class Initializer extends InjectableAware implements ModuleInitializerInterface {

    const VERSION = '1.0.0';

    const SHORT_NAME = 'Shopper';

    /**
     * @return string
     */
    public function name()
    {
        return static::SHORT_NAME . ' [v' . static::VERSION . ']';
    }

    public function url()
    {
        return $this->url->path('shopper/index/welcome');
    }

    /**
     * @throws \Dez\Config\Exception
     */
    public function initialize()
    {
        $this->config->merge(Config::factory([
            'shopper' => []
        ]));

        $this->loader->registerNamespaces([
            __NAMESPACE__ . '\\Controllers' => __DIR__ . '/controllers'
        ])->register();

        $this->router->add('/shopper', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/shopper/:action', [
            'namespace' => __NAMESPACE__ . '\\Controllers',
            'controller' => 'index',
        ]);

        $this->router->add('/shopper/:controller/:action', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/shopper/:controller/:action/:id', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/shopper/:id', [
            'namespace' => __NAMESPACE__ . '\\Controllers',
            'controller' => 'product',
            'action' => 'item',
        ]);

        $this->view->addDirectory('shopper', __DIR__ . '/templates');
    }

}

return new Initializer();