<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\SendDocument, Type\Document, Type\Message, Type\PhotoSize, Type\ReplyKeyboardMarkup
};

class SendDocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendDocument(123, '123-doc-4');
        $method->setDisableNotification(true)
               ->setReplyToMessageId(321);

        $params = $method->getParams();

        $this->assertArrayHasKey('document', $params);
        $this->assertEquals('123-doc-4', $params['document']);
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
        $method = new SendDocument(123, '123-doc-4');

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertInstanceOf(Document::class, $message->document);
        $this->assertInstanceOf(PhotoSize::class, $message->document->thumb);
        $this->assertEquals($data['document']['file_name'], $message->document->fileName);
        $this->assertEquals($data['document']['thumb']['file_id'], $message->document->thumb->fileId);
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
            'document' => [
                'file_id' => 'BQADAgADEQADQqo5BsW2itpONM4WAg',
                'thumb' => [
                    'file_id' => 'AAQCABMfOUgNAARs3zSE0ghw3R0vAAIC',
                    'width' => 90,
                    'height' => 90,
                    'file_size' => 2758
                ],
                'file_name' => 'test.gif',
                'mime_type' => 'image/gif',
                'file_size' => 6223,
            ],
        ];

        return [
            [$data]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendDocument(123, '123-doc-4');
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
        $method = new SendDocument(123, '123-doc-4');

        $this->assertEquals(SendDocument::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendDocument(123, '123-doc-4');

        $this->assertEquals('sendDocument', $method->getMethodName());
    }

    public function testGetSetDocument()
    {
        $method = new SendDocument(123, '123-doc-4');

        $method->setDocument('123-doc-4-5');

        $this->assertEquals('123-doc-4-5', $method->getDocument());
    }

    public function testGetSetCaption()
    {
        $method = new SendDocument(123, '123-doc-4');

        $method->setCaption('Caption');

        $this->assertEquals('Caption', $method->getCaption());
    }
}
