<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class RequestLoggerMiddleware implements MiddlewareInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * <error class> [<error code>] <error message> (<file name>:<line number>)
     */
    protected const LOG_FORMAT = '%s [%d] %s (%s:%d)';

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->logRequest(request: $request);
        return $handler->handle(request: $request);
    }

    protected function logRequest(ServerRequestInterface $request): void
    {
        try {
            $data = [
                'request' => [
                    'uri' => (string)$request->getUri(),
                    'headers' => $request->getHeaders(),
                    'parsed_body' => $request->getParsedBody(),
                    'query_params' => $request->getQueryParams(),
                ],
            ];
            $this->logger->debug(json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES));
        } catch (Throwable $e) {
            $this->logger->error(
                sprintf(
                    self::LOG_FORMAT,
                    get_class($e),
                    $e->getCode(),
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );
        }
    }
}