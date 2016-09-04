<?php

namespace Adminka\Core\Template;

use Dez\Mvc\FactoryContainer;
use Dez\Template\Core\ExtensionInterface;
use Dez\Template\Template;
use Dez\Url\Url;

/**
 * Class ExtensionCore
 * @package Adminka\Core\Template
 */
class ExtensionCore implements ExtensionInterface {

    /**
     * @param Template $template
     * @throws \Dez\Template\TemplateException
     */
    public function register(Template $template)
    {
        $template->registerFunction('url', [$this, 'createURL']);
    }

    /**
     * @param $macros
     * @param array $params
     * @param array $query
     * @return null|string
     */
    public function createURL($macros, array $params = [], array $query = [])
    {
        /** @var Url $url */
        $url = FactoryContainer::instance()->get('url');

        if(false === strpos($macros, ':')) {
            return $url->path($macros, $query);
        } else {
            return $url->create($macros, $params, $query);
        }
    }

}