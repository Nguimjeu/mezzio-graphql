<?php

declare(strict_types=1);

namespace App\Middleware;

use App\MiddlewareTestCase;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddlewareTest extends MiddlewareTestCase
{
    private RequestLoggerMiddleware $middleware;

    private LoggerInterface $logger;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);

        $this->middleware = new RequestLoggerMiddleware();
        $this->middleware->setLogger(logger: $this->logger);
    }

    public function testProcessHandleException(): void
    {
        $this->request->expects(self::once())
        ->method('getUri')
        ->willThrowException(
            new Exception('oops')
        );

        $this->logger->expects(self::never())->method('debug');
        $this->logger->expects(self::once())->method('error');

        $this->middleware->process(request: $this->request, handler: $this->handler);
    }

    public function testProcess(): void
    {
        $this->serverRequestInterfaceExpectations(request: $this->request);

        $this->logger->expects(self::once())->method('debug');
        $this->logger->expects(self::never())->method('error');

        $this->handler->expects(self::once())
            ->method('handle')
            ->with($this->request)
            ->willReturn($this->response);

        $this->middleware->process(request: $this->request, handler: $this->handler);
    }

    protected function serverRequestInterfaceExpectations(ServerRequestInterface|MockObject $request): void
    {
        $request->expects(self::once())
            ->method('getUri')
            ->willReturn('https://some-uri.com');

        $request->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);

        $request->expects(self::once())
            ->method('getParsedBody')
            ->willReturn([]);
        $request->expects(self::once())
            ->method('getQueryParams')
            ->willReturn([]);
    }
}
