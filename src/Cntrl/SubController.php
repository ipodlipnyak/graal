<?php
namespace Cntrl;

use Illuminate\Database\Eloquent\Model;
use Slim\App;
use Slim\Container;

interface SubControllerInterface
{

//     protected function updateData(Container $container, $args = []);

    public function getRenderData(Container $container);

    public function updateRoutes(App $app);
}

class SubController
{

    protected $sub;
    
    protected $render_data;

    final function __construct(Model $sub, $render_data)
    {
        $this->sub = $sub;
        
        $this->render_data = $render_data;
    }

    protected function updateData(Container $container, $args = [])
    {
        // $$this->render_data[$key] = 'value';
    }

    public function updateRoutes(App $app)
    {}

    public function getRenderData(Container $container, $args = [])
    {
        $this->updateData($container);
        return $this->render_data;
    }
}