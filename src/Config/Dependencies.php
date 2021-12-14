<?php

use \Psr\Container\ContainerInterface;
use Cake\Datasource\ConnectionManager;

$container = $app->getContainer();

$container->set('logger', function (ContainerInterface $container) {
    $settings = $container->get('settings')['logger'];
    
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    
    return $logger;
});

// jwt token
$container->set('token', function () {
    return new App\Core\Token;
});

// jwt authentication
$container->set('JwtAuthentication', function (ContainerInterface $container) {
    $settings = $container->get('settings');

    return new Tuupola\Middleware\JwtAuthentication([
        'secure' => false,
        'path' => '/',
        'ignore' => [
            '/v1/ping',
            '/v1/auth'
        ],
        'relaxed' => [],
        'secret' => $settings['jwt']['secret'],
        'error' => function ($response, $arguments) {
            $data = [
                'error' => true,
                'code' => 401,
                'message' => $arguments['message']
            ];

            $response
                ->getBody()
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json');
        },
        'before' => function ($request, array $arguments) use ($container) {
            $container->get('token')->populate($arguments['decoded']);
        }
    ]);
});

// app namespace
Cake\Core\Configure::write('App.namespace', 'App');

$dbSettings = $container->get('settings')['db'];

ConnectionManager::setConfig('default', [
	'className' => \Cake\Database\Connection::class,
	'driver' => \Cake\Database\Driver\Mysql::class,
    'database' => $dbSettings['default']['name'],
    'username' => $dbSettings['default']['user'],
    'password' => $dbSettings['default']['pass'],
    'cacheMetadata' => false,
    'quoteIdentifiers' => false
]);