<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetMe;
use Steelbot\TelegramBotApi\Type\User;

class GetMeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetMe();

        $this->assertEquals('getMe', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetMe();

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetMe();

        $this->assertEquals([], $method->getParams());
    }

    public function testBuildResult()
    {
        $method = new GetMe();

        $result = [
            'id' => 42
        ];
        $user = $method->buildResult($result);

        $this->assertInstanceOf(User::class, $user);
    }
}
