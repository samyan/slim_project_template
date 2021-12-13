<?php

use Monolog\Logger;

$app->getContainer()->set('settings', function () {
    return [
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'slim-skeleton-app',
            'path' => '../logs/app.log',
            'level' => Logger::DEBUG,
        ],
        'db' => [
            'default' => [
                'host' => 'localhost',
                'name' => 'database_name',
                'user' => 'root',
                'pass' => 'toor'
            ]
        ],
        'jwt' => [
            'secret' => '7dbfa580-da89-49ba-a215-9abf56922b85'
        ]
    ];
});
