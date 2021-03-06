<?php

declare(strict_types=1);

namespace App;

use App\Handler\Factory\GraphqlHandlerFactory;
use App\Handler\GraphqlHandler;
use App\Middleware\RequestLoggerMiddleware;
use App\Middleware\RequestLoggerMiddlewareFactory;
use App\Middleware\ResponseLoggerMiddleware;
use App\Middleware\ResponseLoggerMiddlewareFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\HomePageHandler::class,
            ],
            'factories' => [
                GraphqlHandler::class => GraphqlHandlerFactory::class,
                RequestLoggerMiddleware::class => RequestLoggerMiddlewareFactory::class,
                ResponseLoggerMiddleware::class => ResponseLoggerMiddlewareFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => ['templates/app'],
                'error' => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
