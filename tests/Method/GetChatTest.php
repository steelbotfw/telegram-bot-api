<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\AbstractMethod, Method\GetChat, Type\Chat
};

class GetChatTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetChat(1);

        $this->assertEquals('getChat', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetChat(1);

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetChat(1);

        $params = [
            'chat_id' => 1
        ];
        $this->assertEquals($params, $method->getParams());
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($result)
    {
        $method = new GetChat(1);

        $chat = $method->buildResult($result);

        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertEquals($chat->id, 1);
    }

    public function buildResultDataProvider(): array
    {
        $chat = [
            'id' => 1,
            'type' => Chat::TYPE_GROUP
        ];

        return [
            [$chat]
        ];
    }
}
