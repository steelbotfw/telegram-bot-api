<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendContact;
use Steelbot\TelegramBotApi\Type\Contact;
use Steelbot\TelegramBotApi\Type\Message;

class SendContactTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");
        $method->setLastName("Lastman")
               ->setDisableNotification(true)
               ->setReplyToMessageId(321);

        $params = $method->getParams();

        $this->assertArrayHasKey('last_name', $params);
        $this->assertEquals("Lastman", $params['last_name']);
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
        $method = new SendContact($data['chat']['id'], $data['contact']['phone_number'],
            $data['contact']['first_name']
        );

        $message = $method->buildResult($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($data['message_id'], $message->messageId);
        $this->assertEquals($data['from']['id'], $message->from->id);
        $this->assertEquals($data['chat']['id'], $message->chat->id);
        $this->assertInstanceOf(Contact::class, $message->contact);
        $this->assertEquals($data['contact']['phone_number'], $message->contact->phoneNumber);
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
            'contact' => [
                'phone_number' => '+71234567890',
                'first_name' => 'Mr.Who'
            ]
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
            'contact' => [
                'phone_number' => '+71234567891',
                'first_name' => 'Mr.Man'
            ]
        ];

        return [
            [$data],
            [$data2]
        ];
    }

    public function testJsonSerialize()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");

        $json = [
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");

        $this->assertEquals(SendContact::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");

        $this->assertEquals('sendContact', $method->getMethodName());
    }

    public function testGetSetPhoneNumber()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");

        $method->setPhoneNumber("+71234567891");

        $this->assertEquals("+71234567891", $method->getPhoneNumber());
    }

    public function testGetSetFirstName()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");

        $method->setFirstName("Mr.Whoo");

        $this->assertEquals("Mr.Whoo", $method->getFirstName());
    }

    public function testGetSetLastName()
    {
        $method = new SendContact(123, '+71234567890', "Mr.Who");

        $method->setLastName("Lastman");

        $this->assertEquals("Lastman", $method->getLastName());
    }
}
