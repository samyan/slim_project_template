<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    /**
     * Create Slim route format
     *
     * @param array $args
     * @return string
     */
    public static function create(array $args): string
    {
        ['controller' => $controller, 'action' => $action] = $args;

        return sprintf('App\\Controller\\%sController:%s', $controller, $action);
    }
}
