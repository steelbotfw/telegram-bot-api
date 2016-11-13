<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendLocation;
use Steelbot\TelegramBotApi\Type\Message;

class SendLocationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendLocation(123, 80.635561, 49.910422);
        $method->setDisableNotification(true)
               ->setReplyToMessageId(321);

        $params = $method->getParams();

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
        $method = new SendLocation($data['chat']['id'], $data['location']['latitude'], $data['location']['longitude']);

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertEquals($data['location']['latitude'], $message->location->latitude);
        $this->assertEquals($data['location']['longitude'], $message->location->longitude);
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
            'location' => [
                'latitude' => 80.635561,
                'longitude' => 49.910422
            ],

            'date' => 1456600086,
            'text' => null
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
            'location' => [
                'latitude'  => 80.987654,
                'longitude' => 47.123456
            ],

            'date' => 1456600086,
            'text' => null
        ];

        return [
            [$data],
            [$data2]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendLocation(123, 80.98765, 47.12345);

        $json = [];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SendLocation(123, 80.635561, 49.910422);

        $this->assertEquals(SendLocation::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendLocation(123, 80.635561, 49.910422);

        $this->assertEquals('sendLocation', $method->getMethodName());
    }

    public function testGetSetLatitude()
    {
        $method = new SendLocation(123, 80.635561, 49.910422);
        $method->setLatitude(79.6);

        $this->assertEquals(79.6, $method->getLatitude());
    }

    public function testGetSetLongitude()
    {
        $method = new SendLocation(123, 80.635561, 49.910422);
        $method->setLongitude(48.9);

        $this->assertEquals(48.9, $method->getLongitude());
    }
}
