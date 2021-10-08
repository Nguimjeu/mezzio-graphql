<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GrahqlHandler implements RequestHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            [
                'method' => __METHOD__,
                'app_name' => getenv('APP_NAME'),
                'environment' => getenv('ENVIRONMENT'),
            ]
        );
    }
}