<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\UnbanChatMember;

class UnbanChatMemberTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new UnbanChatMember(123, 31337);

        $params = $method->getParams();

        $this->assertArrayHasKey('chat_id', $params);
        $this->assertEquals(123, $params['chat_id']);
        $this->assertArrayHasKey('user_id', $params);
        $this->assertEquals(31337, $params['user_id']);
    }

    public function testBuildResult()
    {
        $method = new UnbanChatMember(123, 31337);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }

    public function testGetHttpMethod()
    {
        $method = new UnbanChatMember(123, 31337);

        $this->assertEquals(UnbanChatMember::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new UnbanChatMember(123, 31337);

        $this->assertEquals('unbanChatMember', $method->getMethodName());
    }

    public function testGetSetUserId()
    {
        $method = new UnbanChatMember(123, 31337);

        $method->setUserId(321);

        $this->assertEquals(321, $method->getUserId());
    }
}
