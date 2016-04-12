<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendMessage;
use Steelbot\TelegramBotApi\ParseMode;
use Steelbot\TelegramBotApi\Type\Message;

class SendMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendMessage(123, "Hello");
        $method->setDisableWebPagePreview(true)
               ->setDisableNotification(true)
               ->setReplyToMessageId(321)
               ->setParseMode(ParseMode::MARKDOWN);

        $params = $method->getParams();

        $this->assertArrayHasKey('disable_web_page_preview', $params);
        $this->assertEquals(1, $params['disable_web_page_preview']);
        $this->assertArrayHasKey('disable_notification', $params);
        $this->assertEquals(1, $params['disable_notification']);
        $this->assertArrayHasKey('reply_to_message_id', $params);
        $this->assertEquals(321, $params['reply_to_message_id']);
        $this->assertArrayHasKey('parse_mode', $params);
        $this->assertEquals(ParseMode::MARKDOWN, $params['parse_mode']);
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($data)
    {
        $method = new SendMessage($data['chat']['id'], $data['text']);

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
            'message_id' => 4757,
            'from' => [
                'id' => 987654320,
                'first_name' => 'Steel Bot',
                'username' => 'SteelbotBot'
            ],

            'chat' => [
                'id' => 987654321,
                'first_name' => 'Mister',
                'last_name' => 'Botman',
                'username' => 'mrbotman',
                'type' => 'private'
            ],

            'date' => 1456600086,
            'text' => 'Hello there!'
        ];

        $data2 = [
            'message_id' => 4757,
            'from' => [
                'id' => 987654320,
                'username' => 'SteelbotBot'
            ],

            'chat' => [
                'id' => 987654321,
                'type' => 'private'
            ],

            'date' => 1456600086,
            'text' => 'Hello there!'
        ];

        return [
            [$data],
            [$data2]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendMessage(123, "Hello");

        $json = [
            'text' => "Hello"
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SendMessage(123, "Hello");

        $this->assertEquals(SendMessage::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendMessage(123, "Hello");

        $this->assertEquals('sendMessage', $method->getMethodName());
    }

    public function testGetSetText()
    {
        $method = new SendMessage(123, "Old text");

        $method->setText("New text");

        $this->assertEquals("New text", $method->getText());
    }

    public function testGetSetChatId()
    {
        $method = new SendMessage(123, "Hello");

        $method->setChatId('@chatid');

        $this->assertEquals('@chatid', $method->getChatId());
    }
}
