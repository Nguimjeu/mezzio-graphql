<?php

declare(strict_types=1);

namespace App\Service\Logging;

use App\FactoryTestCase;
use Monolog\Logger;

class LoggerFactoryTest extends FactoryTestCase
{
private LoggerFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new LoggerFactory();
    }

    public function test__invoke(): void
    {
        $actual = ($this->factory)(container: $this->container);

        self::assertInstanceOf(Logger::class, actual: $actual);
    }
}
