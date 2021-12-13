<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

AppFactory::setContainer(new \DI\Container());

$app = AppFactory::create();

// Set up settings
require __DIR__ . '/../src/Config/Settings.php';

// Set up dependencies
require __DIR__ . '/../src/Config/Dependencies.php';

// Register middleware
require __DIR__ . '/../src/Config/Middleware.php';

// Register routes
require __DIR__ . '/../src/Config/Routes.php';

// Add Routing Middleware
$app->addRoutingMiddleware();

$displayErrorDetails = $app->getContainer()->get('settings')['displayErrorDetails'];

/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

// https://www.slimframework.com/docs/v4/start/upgrade.html#changes-to-base-path-handling
// $app->setBasePath('/slim_skeleton/public');

// Run app
$app->run();
