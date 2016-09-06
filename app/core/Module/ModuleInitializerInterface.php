<?php

namespace Adminka\Core\Module;

interface ModuleInitializerInterface {

    public function initialize();

    public function name();

    public function url();

}