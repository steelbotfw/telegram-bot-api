<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendSticker;
use Steelbot\TelegramBotApi\Type\PhotoSize;
use Steelbot\TelegramBotApi\Type\Sticker;
use Steelbot\TelegramBotApi\Type\Message;

class SendStickerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendSticker(123, '1234');
        $method->setDisableNotification(true)
               ->setReplyToMessageId(321);

        $params = $method->getParams();

        $this->assertArrayHasKey('chat_id', $params);
        $this->assertEquals(123, $params['chat_id']);
        $this->assertArrayHasKey('sticker', $params);
        $this->assertEquals('1234', $params['sticker']);
        $this->assertArrayHasKey('disable_notification', $params);
        $this->assertEquals(1, $params['disable_notification']);
        $this->assertArrayHasKey('reply_to_message_id', $params);
        $this->assertEquals(321, $params['reply_to_message_id']);
    }

    /**
     * @dataProvider buildResultDataProvider
     */
    public function testBuildResult($data)
    {
        $method = new SendSticker($data['chat']['id'], $data['sticker']['file_id']);

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertInstanceOf(Sticker::class, $message->sticker);
        $this->assertEquals($data['sticker']['file_id'], 'BQADBQADxwEAAukKyANsxuIuEZZ6bQI');
        $this->assertInstanceOf(PhotoSize::class, $message->sticker->thumb);
        $this->assertEquals($data['sticker']['thumb']['file_id'], 'AAQFABMGar4yAASPHSYG3pPkCnUdAAIC');
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
            'sticker' => [
                'file_id' => 'BQADBQADxwEAAukKyANsxuIuEZZ6bQI',
                'width' => 512,
                'height' => 512,
                'thumb' => [
                    'file_id' => 'AAQFABMGar4yAASPHSYG3pPkCnUdAAIC',
                    'width' => 128,
                    'height' => 128,
                    'file_size' => 3862
                ],
                'file_size' => 22016
            ]
        ];

        return [
            [$data]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendSticker(123, '1234');

        $json = [
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SendSticker(123, '1234');

        $this->assertEquals(SendSticker::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendSticker(123, '1234');

        $this->assertEquals('sendSticker', $method->getMethodName());
    }

    public function testGetSetChatId()
    {
        $method = new SendSticker(123, '1234');

        $method->setChatId('@chatid');

        $this->assertEquals('@chatid', $method->getChatId());
    }
}
