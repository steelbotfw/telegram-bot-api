<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\ForwardMessage;
use Steelbot\TelegramBotApi\Type\Message;

class ForwardMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($data)
    {
        $method = new ForwardMessage(123, 456, 789);

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertEquals($data['text'], $message->text);
    }

    public function buildResultDataProvider()
    {
        $data = [
            'message_id' => 4567,
            'from' => [
                'id' => 987654320
            ],
            'chat' => [
                'id' => 12345678,
                'type' => 'private'
            ],
            'text' => "Hello",
            'date' => time()
        ];

        return [
            [$data]
        ];
    }

    public function testGetParams()
    {
        $method = new ForwardMessage(123, 456, 789);
        $method->setDisableNotification(true);

        $params = $method->getParams();

        $this->assertArrayHasKey('disable_notification', $params);
        $this->assertEquals(1, $params['disable_notification']);
        $this->assertArrayHasKey('chat_id', $params);
        $this->assertEquals(123, $params['chat_id']);
        $this->assertArrayHasKey('from_chat_id', $params);
        $this->assertEquals(456, $params['from_chat_id']);
        $this->assertArrayHasKey('message_id', $params);
        $this->assertEquals(789, $params['message_id']);
    }
}
