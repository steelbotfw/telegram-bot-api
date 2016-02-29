<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\ForwardMessage;
use Steelbot\TelegramBotApi\Type\Message;

class ForwardMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildResult()
    {
        $method = new ForwardMessage(123, 456, 789);

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
        $method = new ForwardMessage(123, 456, 789);

        $json = [
            'text' => "Hello"
        ];
        $json = json_encode([], JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }
}
