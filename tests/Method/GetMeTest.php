<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Icicle\Coroutine\Coroutine;
use Icicle\Http\Client\Client;
use Icicle\Http\Message\Response;
use Steelbot\TelegramBotApi\Api;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\GetMe;
use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\Type\User;
use Steelbot\Tests\TelegramBotApi\Stub\ReadableStreamStub;
use Steelbot\TelegramBotApi\Exception\TelegramBotApiException;

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

    public function testJsonSerialize()
    {
        $method = new GetMe();

        $json = json_encode([], JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }
}
