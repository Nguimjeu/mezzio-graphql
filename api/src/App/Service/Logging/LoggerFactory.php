<?php

declare(strict_types=1);

namespace App\Service\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\HostnameProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container): LoggerInterface
    {
        $appName = getenv('APP_NAME') ?? '<app-name-not-set>';
        $logger = new Logger($appName);

        $handler = new StreamHandler(
            'php://stdout',
            Logger::DEBUG,
            true
        );

        $logger->pushHandler(handler: $handler);
        $logger->pushProcessor(new PsrLogMessageProcessor())
            ->pushProcessor(new HostnameProcessor());

        return $logger;
    }

}
