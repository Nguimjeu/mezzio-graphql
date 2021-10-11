<?php

declare(strict_types=1);

namespace App\Middleware;

use App\MiddlewareTestCase;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

class ResponseLoggerMiddlewareTest extends MiddlewareTestCase
{
    private ResponseLoggerMiddleware $middleware;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);

        $this->middleware = new ResponseLoggerMiddleware();
        $this->middleware->setLogger(logger: $this->logger);
    }

    public function testProcessHandleException(): void
    {
        $this->handler->expects(self::once())
            ->method('handle')
            ->with(self::identicalTo($this->request))
            ->willReturn($this->response);

        $this->response->expects(self::once())
            ->method('getStatuscode')
            ->willThrowException(
                new Exception('oops')
            );

        $this->logger->expects(self::never())->method('debug');
        $this->logger->expects(self::once())->method('error');

        $this->middleware->process(request: $this->request, handler: $this->handler);
    }

    public function testProcess(): void
    {
        $this->handler->expects(self::once())
            ->method('handle')
            ->with(self::identicalTo($this->request))
            ->willReturn($this->response);

        $this->response->expects(self::once())
            ->method('getStatuscode')
            ->willReturn(StatusCodeInterface::STATUS_OK);

        $this->response->expects(self::once())
            ->method('getReasonPhrase')
            ->willReturn('OK');

        $this->response->expects(self::once())
            ->method('getHeaders')
            ->willReturn([]);

        $body = $this->createMock(StreamInterface::class);
        $this->response->expects(self::once())
            ->method('getBody')
            ->willReturn($body);
        $body->expects(self::once())
            ->method('getContents')
            ->willReturn('foo-content');

        $this->logger->expects(self::once())->method('debug');
        $this->logger->expects(self::never())->method('error');

        $this->middleware->process(request: $this->request, handler: $this->handler);
    }
}
