<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class HttpMonitor
{
    /**
     * Logger
     *
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * Constructor
     *
     * @param \Monolog\Logger $logger
     */
    public function __construct(\Monolog\Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Invoke
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        $this->logger->info(json_encode(['method' => 'request', 'url' => $request->getUri()->getPath(), 'data' => $request->getParsedBody()]));
        $this->logger->info(json_encode(['method' => 'response', 'data' => json_decode($response->getBody()->__toString())]));

        return $response;
    }
}
