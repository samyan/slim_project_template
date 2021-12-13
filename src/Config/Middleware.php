<?php

$container = $app->getContainer();

$logger = $container->get('logger');

$app->add(new App\Middleware\JsonBodyParser());
$app->add(new App\Middleware\HttpMonitor($logger));
$app->add(new App\Middleware\Cors('http://localhost:3001', ['http://localhost:3000']));
$app->add(RKA\Middleware\IpAddress::class);
$app->add($container->get('JwtAuthentication'));