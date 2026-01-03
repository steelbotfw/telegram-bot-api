<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\AbstractMethod,
    Method\LeaveChat
};
use PHPUnit\Framework\TestCase;

class LeaveChatTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetMethodName()
    {
        $method = new LeaveChat(1);

        $this->assertEquals('leaveChat', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new LeaveChat(1);

        $this->assertEquals(AbstractMethod::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new LeaveChat(1);

        $params = [
            'chat_id' => 1
        ];
        $this->assertEquals($params, $method->getParams());
    }

    public function testBuildResult()
    {
        $method = new LeaveChat(1);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }
}
