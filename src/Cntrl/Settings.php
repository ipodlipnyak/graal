<?php
namespace Cntrl;

/**
 * Settings
 *
 * @author havactik
 *        
 */
class Settings
{

    static $devMode = true;

    static $dbConfMain = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'graal',
        'username' => 'admin',
        'password' => 'pass',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ];

    static function getSlimSettings()
    {
        return [
            'settings' => [
                'displayErrorDetails' => true, // set to false in production
                'addContentLengthHeader' => false, // Allow the web server to send the content-length header

                // Twig settings
                'twigPath' => __DIR__ . '/../view/templates',
                'twigSettings' => Settings::$devMode ? [
                    'cache' => false
                ] : [
                    'cache' => __DIR__ . '/../view/cache'
                ],

                // Monolog settings
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/app.log',
                    'level' => \Monolog\Logger::DEBUG
                ]
            ]
        ];
    }
}

