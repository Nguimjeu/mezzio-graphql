<?php

declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class HandlerTestCase extends TestCase
{
    protected ServerRequestInterface $request;

    protected ResponseInterface $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
    }
}