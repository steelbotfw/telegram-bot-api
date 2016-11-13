<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\SendAudio,
    Type\Audio,
    Type\Message,
    Type\ReplyKeyboardMarkup
};

class SendAudioTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendAudio(123, '123-4');
        $method->setDisableNotification(true)
               ->setReplyToMessageId(321);

        $params = $method->getParams();

        $this->assertArrayHasKey('audio', $params);
        $this->assertEquals('123-4', $params['audio']);
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
        $method = new SendAudio(123, '123-4');

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertInstanceOf(Audio::class, $message->audio);
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
            'audio' => [
                'duration' => 260,
                'mime_type' => 'audio/mpeg',
                'title' => 'Some title',
                'performer' => 'Some Performer',
                'file_id' => 'SOMEFileId-123',
                'file_size' => 10558221
            ]

        ];

        return [
            [$data]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendAudio(123, '123-4');
        $method->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']))
            ->setDuration(42)
            ->setPerformer('Some Performer')
            ->setTitle('Some Title');

        $json = [
            'reply_markup' => ['keyboard' => ['1', '2', '3']],
            'duration' => 42,
            'performer' => 'Some Performer',
            'title' => 'Some Title'
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SendAudio(123, '123-4');

        $this->assertEquals(SendAudio::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendAudio(123, '123-4');

        $this->assertEquals('sendAudio', $method->getMethodName());
    }

    public function testGetSetDuration()
    {
        $method = new SendAudio(123, '123-4');

        $this->assertNull($method->getDuration());

        $method->setDuration(42);

        $this->assertEquals(42, $method->getDuration());
    }

    public function testGetSetPerformer()
    {
        $method = new SendAudio(123, '123-4');

        $this->assertNull($method->getPerformer());

        $method->setPerformer('Some Performer');

        $this->assertEquals('Some Performer', $method->getPerformer());
    }

    public function testGetSetTitle()
    {
        $method = new SendAudio(123, '123-4');

        $this->assertNull($method->getTitle());

        $method->setTitle('Some Title');

        $this->assertEquals('Some Title', $method->getTitle());
    }
}
