<?php

declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class FactoryTestCase extends TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = $this->createMock(ContainerInterface::class);
    }

}