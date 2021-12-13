<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Cors
{
    private string $defaultOrigin;
    private array $origins;

    /**
     * Constructor
     *
     * @param string $defaultOrigin
     * @param array $origins
     */
    public function __construct(string $defaultOrigin, array $origins)
    {
        $this->defaultOrigin = $defaultOrigin;
        $this->origins = $origins;
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
        if ($this->defaultOrigin === null) {
            throw new \Exception('Default origin is empty');
        }

        $response = $handler->handle($request);
        $httpOrigin = isset($_SERVER["HTTP_ORIGIN"]) ? $_SERVER["HTTP_ORIGIN"] : $_SERVER["SERVER_NAME"];
        $origin = null;

        if (count($this->origins) > 0) {
            foreach ($this->origins as $eachOrigin) {
                if (strrpos($httpOrigin, $eachOrigin) !== false) {
                    $origin = $httpOrigin;
                    break;
                }
            }
        } else {
            $origin = '*';
        }

        $origin = $origin !== null ? $origin : $this->defaultOrigin;

        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }
}
