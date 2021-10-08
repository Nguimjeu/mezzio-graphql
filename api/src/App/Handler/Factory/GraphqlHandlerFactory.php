<?php

declare(strict_types=1);

namespace App\Handler\Factory;


use App\Handler\GraphqlHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class GraphqlHandlerFactory
{

    public function __invoke(ContainerInterface $container): GraphqlHandler
    {
        $handler = new GraphqlHandler();
        $handler->setLogger(
            $container->get(LoggerInterface::class)
        );

        return $handler;
    }
}