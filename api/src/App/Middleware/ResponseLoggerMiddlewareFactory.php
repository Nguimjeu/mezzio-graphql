<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class ResponseLoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): ResponseLoggerMiddleware
    {
        $middleware = new ResponseLoggerMiddleware();
        $middleware->setLogger(
            $container->get(LoggerInterface::class)
        );

        return $middleware;
    }

}