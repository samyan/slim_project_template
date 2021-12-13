<?php

use App\Core\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy as Group;

$app->options('/{routes:.+}', function (Request $request, Response $response, array $args) {
    return $response;
});

$app->group('/v1', function (Group $group) {

    $group->get('/ping', Router::create(['controller' => 'Auth', 'action' => 'ping']));
    $group->post('/auth', Router::create(['controller' => 'Auth', 'action' => 'login']));

})->add(new App\Middleware\MaintenanceCheck());