<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\AbstractMethod,
    Method\GetChatMembersCount
};

class GetChatMembersCountTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetChatMembersCount(1);

        $this->assertEquals('getChatMembersCount', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetChatMembersCount(1);

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetChatMembersCount(1);

        $params = [
            'chat_id' => 1
        ];
        $this->assertEquals($params, $method->getParams());
    }

    public function testBuildResult()
    {
        $method = new GetChatMembersCount(1);

        $count = $method->buildResult(42);

        $this->assertEquals(42, $count);
    }
}
