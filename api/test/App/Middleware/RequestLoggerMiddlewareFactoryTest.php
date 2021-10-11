<?php

declare(strict_types=1);

namespace App\Middleware;

use App\FactoryTestCase;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddlewareFactoryTest extends FactoryTestCase
{
    private RequestLoggerMiddlewareFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new RequestLoggerMiddlewareFactory();
    }

    public function test__invoke(): void
    {
        $this->container->expects(self::once())
            ->method('get')
            ->with(
                self::identicalTo(LoggerInterface::class)
            )
            ->willReturn(
                $this->createMock(LoggerInterface::class)
            );

        ($this->factory)(container: $this->container);
    }
}
