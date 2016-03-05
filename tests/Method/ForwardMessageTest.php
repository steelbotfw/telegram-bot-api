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
}
