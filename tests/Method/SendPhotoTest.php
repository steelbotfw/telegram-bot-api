<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendPhoto;
use Steelbot\TelegramBotApi\Type\Contact;
use Steelbot\TelegramBotApi\Type\Message;
use Steelbot\TelegramBotApi\Type\PhotoSize;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class SendPhotoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendPhoto(123, '123-4');
        $method->setDisableNotification(true)
               ->setReplyToMessageId(321);

        $params = $method->getParams();

        $this->assertArrayHasKey('photo', $params);
        $this->assertEquals("123-4", $params['photo']);
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
        $method = new SendPhoto(123, '123-4');

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        foreach ($message->photo as $photoSize) {
            $this->assertInstanceOf(PhotoSize::class, $photoSize);
        }
    }

    /**
     * @return array
     */
    public function buildResultDataProvider(): array
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
            'photo' => [
                [
                    'file_id' => 'AgADAgAD9agxG0KqOQakmrlYi0MrxMLVRw0ABA-Yx_w0DoDCMr0AAgI',
                    'file_size' => 1602,
                    'width' => 90,
                    'height' => 82
                ],
                [
                    'file_id' => 'AgADAgAD9agxG0KqOQakmrlYi0MrxMLVRw0ABC7XmCU7c_ejM70AAgI',
                    'file_size' => 18429,
                    'width' => 320,
                    'height' => 292,
                ],
                [
                    'file_id' => 'AgADAgAD9agxG0KqOQakmrlYi0MrxMLVRw0ABFf2o2GK5BcIMb0AAgI',
                    'file_size' => 20188,
                    'width' => 400,
                    'height' => 365
                ],
            ]
        ];

        return [
            [$data]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendPhoto(123, '123-4');
        $method->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']))
            ->setCaption('Caption');

        $json = [
            'reply_markup' => ['keyboard' => ['1', '2', '3']],
            'caption' => 'Caption'
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SendPhoto(123, '123-4');

        $this->assertEquals(SendPhoto::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendPhoto(123, '123-4');

        $this->assertEquals('sendPhoto', $method->getMethodName());
    }

    public function testGetSetPhoto()
    {
        $method = new SendPhoto(123, '123-4');

        $method->setPhoto('123-4-5');

        $this->assertEquals('123-4-5', $method->getPhoto());
    }

    public function testGetSetCaption()
    {
        $method = new SendPhoto(123, '123-4');

        $method->setCaption('Caption');

        $this->assertEquals('Caption', $method->getCaption());
    }

    public function testGetSetChatId()
    {
        $method = new SendPhoto(123, '123-4');

        $method->setChatId('@chatid');

        $this->assertEquals('@chatid', $method->getChatId());
    }
}
