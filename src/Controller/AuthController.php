<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Core\ResponseHandler;

class AuthController extends Controller
{
    /**
     * Ping request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     * @return void
     */
    public function ping(Request $request, Response $response, array $args)
    {
        $ipAddress = $request->getAttribute('ip_address');

        $data = ['message' => 'pong', 'ip' => $ipAddress];

        return ResponseHandler::write($response, $data);
    }

    /**
     * Login request
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        try {
            die('auth ok');

            return ResponseHandler::write($response, ['prueba' => 'ok']);

            /*
            $body = $request->getParsedBody();

            $ipAddress = $request->getAttribute('ip_address');

            $now = new \DateTime('now', new \DateTimeZone('UTC'));
            $future = new \DateTime('now +12 hours', new \DateTimeZone('UTC'));
            $jti = (new Base62)->encode(random_bytes(16));

            $payload = [
                'iat' => $now->getTimeStamp(),
                'exp' => $future->getTimeStamp(),
                'jti' => $jti,
                'sub' => 'user_id_example',
            ];

            $secret = $this->container->JwtAuthentication->getSecret();
            $token = JWT::encode($payload, $secret, 'HS256');

            $data = [
                'session' => ['token' => $token],
                'expires' => $future->getTimeStamp()
            ];

            return ResponseHandler::write($response, false, $data);
            */
        } catch (\Exception $e) {
            return ResponseHandler::write($response, ResponseHandler::INTERNAL_ERROR);
        }
    }
}
