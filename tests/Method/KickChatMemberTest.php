<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\KickChatMember;

class KickChatMemberTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new KickChatMember(123, 31337);

        $params = $method->getParams();

        $this->assertArrayHasKey('chat_id', $params);
        $this->assertEquals(123, $params['chat_id']);
        $this->assertArrayHasKey('user_id', $params);
        $this->assertEquals(31337, $params['user_id']);
    }

    public function testBuildResult()
    {
        $method = new KickChatMember(123, 31337);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }

    public function testGetHttpMethod()
    {
        $method = new KickChatMember(123, 31337);

        $this->assertEquals(KickChatMember::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new KickChatMember(123, 31337);

        $this->assertEquals('kickChatMember', $method->getMethodName());
    }

    public function testGetSetUserId()
    {
        $method = new KickChatMember(123, 31337);

        $method->setUserId(321);

        $this->assertEquals(321, $method->getUserId());
    }

    public function testGetSetChatId()
    {
        $method = new KickChatMember(123, 31337);

        $method->setChatId('@chatid');

        $this->assertEquals('@chatid', $method->getChatId());
    }
}
