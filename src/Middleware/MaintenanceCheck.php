<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class MaintenanceCheck
{
    /**
     * Invoke
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        /*
        $connection = ConnectionManager::get('default');

        $config = $connection
            ->newQuery()
            ->select(['value'])
            ->from(['config'])
            ->where(['name' => 'maintenance'])
            ->execute()
            ->fetch('assoc');

        if (!empty($config)) {
            if ((int) $config['value'] === 1) {
                $response = new Response();
                $response
                    ->getBody()
                    ->write(json_encode(['error' => false], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(503);
            }
        }
        */

        return $handler->handle($request);
    }
}
