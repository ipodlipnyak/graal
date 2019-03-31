<?php
namespace Cntrl;

use Slim;

/**
 * Master class.
 * Primarily used to initialise slim modules
 *
 * @author havactik
 *        
 */
class Master
{

    protected $app = [];

    public function __construct(Slim\App $app)
    {
        $this->app = $app;
    }

    public function initSlimDependencies()
    {
        $dependencies = new Dependencies($this->app);
        $dependencies->init();

        return $this;
    }

    public function initSlimRoutes()
    {
        $routes = new Routes($this->app);
        $routes->init();

        return $this;
    }

    public function initSlimMiddleware()
    {
        $middleware = new Middleware($this->app);
        $middleware->init();

        return $this;
    }
}