<?php

namespace Adminka\Core;

use Dez\Auth\Auth;
use Dez\Authorizer\Adapter\Token;
use Dez\Config\Config;
use Dez\Db\Connection;
use Dez\DependencyInjection\Injectable;
use Dez\EventDispatcher\Dispatcher;
use Dez\Flash\Flash\Session;
use Dez\Http\Cookies;
use Dez\Http\Request;
use Dez\Http\Response;
use Dez\Loader\Loader;
use Dez\Router\Router;
use Dez\Session\Adapter;
use Dez\Url\Url;
use Dez\View\View;

abstract class InjectableAware extends Injectable implements \Dez\Mvc\InjectableAware { }