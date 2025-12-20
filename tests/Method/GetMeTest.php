<?php

declare(strict_types=1);

namespace Steelbot\Tests\TelegramBotApi\Method;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetMe;
use Steelbot\TelegramBotApi\Type\User;

class GetMeTest extends TestCase
{
    public function testGetMethodName(): void
    {
        $method = new GetMe();

        $this->assertEquals('getMe', $method->getMethodName());
    }

    public function testGetHttpMethod(): void
    {
        $method = new GetMe();

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams(): void
    {
        $method = new GetMe();

        $this->assertEquals([], $method->getParams());
    }

    public function testBuildResult(): void
    {
        $method = new GetMe();

        $result = [
            'id' => 42
        ];
        $user = $method->buildResult($result);

        $this->assertInstanceOf(User::class, $user);
    }
}
