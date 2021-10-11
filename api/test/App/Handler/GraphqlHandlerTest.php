<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class GraphqlHandlerTest extends TestCase
{
    private GraphqlHandler $handler;

    private LoggerInterface $logger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->handler = new GraphqlHandler();
        $this->handler->setLogger(logger: $this->logger);
    }

    public function testHandle(): void
    {
        $actual = $this->handler->handle(
            request: $this->createMock(ServerRequestInterface::class)
        );

        self::assertInstanceOf(JsonResponse::class, actual: $actual);
        self::assertSame(200, $actual->getStatusCode());
    }
}
