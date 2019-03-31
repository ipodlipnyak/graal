<?php
namespace Cntrl;

use Slim;

interface SlimModule
{

    public function init();
}

class SlimWrapper
{

    protected $settings = [];

    protected $container = [];

    protected $app = [];

    function __construct(Slim\App $app)
    {
        $this->app = $app;
        $this->container = $app->getContainer();
        $this->settings = $this->container->get('settings');
    }
}