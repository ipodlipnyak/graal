<?php
namespace Cntrl;

use Monolog;
use Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Dependencies
 *
 * @author havactik
 *        
 */
final class Dependencies extends SlimWrapper implements SlimModule
{

    public function init()
    {
        $this->initTwig();
        $this->initLogger();
    }

    /**
     * Twig template engine
     */
    protected function initTwig()
    {
        $this->container['view'] = function ($container) {

            $view = new Twig($container->get('settings')['twigPath'], $container->get('settings')['twigSettings']);

            // Instantiate and add Slim specific extension
            $router = $container->get('router');
            $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));

            return $view;
        };
    }

    /**
     * monolog
     */
    protected function initLogger()
    {
        $this->container['logger'] = function ($c) {
            $settings = $c->get('settings')['logger'];
            $logger = new Monolog\Logger($settings['name']);
            $logger->pushProcessor(new Monolog\Processor\UidProcessor());
            $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
            return $logger;
        };
    }
}