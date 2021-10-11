<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): RequestLoggerMiddleware
    {
        $middleware = new RequestLoggerMiddleware();
        $middleware->setLogger(
            $container->get(LoggerInterface::class)
        );

        return $middleware;
    }

}