<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\Type\Message;

class SendMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildResult()
    {
        $method = new SendMessage(123, "Hello");

        $result = [
            'message_id' => 123,
            'chat' => [
                'type' => 'private',
                'id' => 123
            ],
            'date' => time()
        ];
        $message = $method->buildResult($result);

        $this->assertInstanceOf(Message::class, $message);
    }

    function testJsonSerialize()
    {
        $method = new SendMessage(123, "Hello");

        $json = [
            'text' => "Hello"
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

}
