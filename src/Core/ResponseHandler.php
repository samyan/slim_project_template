<?php

declare(strict_types=1);

namespace App\Core;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseHandler
{
    const INTERNAL_ERROR = [
        'status' => 500,
        'code' => 500,
        'message' => 'Internal error'
    ];

    const AUTH_ERROR = [
        'status' => 401,
        'code' => 401,
        'message' => 'Invalid authentication'
    ];

    const PERMISSIONS_ERROR = [
        'status' => 403,
        'code' => 403,
        'message' => 'Insufficient permissions'
    ];

    /**
     * Write response
     *
     * @param \Psr\Http\Message\ResponseInterface $responseHandler
     * @param array $data
     * @param array $error
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function write(Response $responseHandler, array $data = [], array $error = []): Response
    {
        $isErrorExists = count($error) > 0;

        if ($isErrorExists) {
            ['code' => $code, 'message' => $message] = $error;

            $responseData = ['error' => true, 'code' => $code, 'message' => $message];
        } else {
            $responseData = ['error' => false, 'data' => $data];
        }

        $responseHandler
            ->getBody()
            ->write(json_encode($responseData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        return $responseHandler
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($isErrorExists ? $error['status'] : 200);
    }
}
