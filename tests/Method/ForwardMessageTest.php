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
}
