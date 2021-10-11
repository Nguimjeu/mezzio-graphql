<?php

declare(strict_types=1);

namespace App\Handler;

use App\HandlerTestCase;
use Laminas\Diactoros\Response\JsonResponse;

class HomePageHandlerTest extends HandlerTestCase
{
    private HomePageHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new HomePageHandler();
    }

    public function testHandle(): void
    {
        $actual = $this->handler->handle(request: $this->request);
        self::assertInstanceOf(JsonResponse::class, actual: $actual);
        self::assertSame(
            [
                'help' => 'use {{base-url}}/graphql',
            ],
            json_decode(
                $actual->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            )
        );
    }
}
