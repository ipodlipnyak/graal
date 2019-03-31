<?php
use Cntrl\Master;
use Cntrl\Settings;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Setup the Eloquent ORM
$capsule = new Capsule();
$capsule->addConnection(Settings::$dbConfMain, 'main_db');

// Set the event dispatcher used by Eloquent models
$capsule->setEventDispatcher(new Dispatcher(new Container()));

$capsule->bootEloquent();

session_start();

// Instantiate the app
$settings = Settings::getSlimSettings();
$app = new \Slim\App($settings);

// Set up dependencies, register middleware, register routes
$master = new Master($app);
$master->initSlimDependencies()
    ->initSlimMiddleware()
    ->initSlimRoutes();

// Run app
$app->run();
