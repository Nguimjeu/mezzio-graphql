<?php

declare(strict_types=1);

namespace App\Handler\Factory;

use App\FactoryTestCase;
use Psr\Log\LoggerInterface;

class GraphqlHandlerFactoryTest extends FactoryTestCase
{
    private GraphqlHandlerFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new GraphqlHandlerFactory();
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

        ($this->factory)($this->container);
    }
}
