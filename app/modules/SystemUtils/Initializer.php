<?php

namespace SystemUtils;
use Adminka\Core\InjectableAware;
use Adminka\Core\Module\ModuleInitializerInterface;
use Dez\Config\Config;

/**
 * Class Initializer
 * @package SystemUtils
 */
class Initializer extends InjectableAware implements ModuleInitializerInterface {

    const VERSION = '1.0.0';

    const SHORT_NAME = 'System Utils';

    /**
     * @return string
     */
    public function name()
    {
        return static::SHORT_NAME . ' [v' . static::VERSION . ']';
    }

    public function url()
    {
        return $this->url->path('system_utils/index/index');
    }

    /**
     * @throws \Dez\Config\Exception
     */
    public function initialize()
    {
        $this->config->merge(Config::factory([
            'utils' => []
        ]));

        $this->loader->registerNamespaces([
            __NAMESPACE__ . '\\Controllers' => __DIR__ . '/controllers',
        ])->register();

        $this->router->add('/system_utils', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/system_utils/:controller', [
            'namespace' => __NAMESPACE__ . '\\Controllers',
            'controller' => 'index',
        ]);

        $this->router->add('/system_utils/:controller/:action', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

        $this->router->add('/system_utils/:controller/:action/:id', [
            'namespace' => __NAMESPACE__ . '\\Controllers'
        ]);

//        $this->view->addDirectory('utils', __DIR__ . '/templates');
    }

}

return new Initializer();