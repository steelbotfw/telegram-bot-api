<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultContact,
    InputMessageContent\InputTextMessageContent,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultContactTest extends \PHPUnit_Framework_TestCase
{
    const THUMB_URL = 'http://example.com/img.jpg';

    /**
     * @var InlineQueryResultContact
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultContact(null, '+0123456789', 'Firstname');
    }

    public function testGetSetPhoneNumber()
    {
        $this->assertEquals('+0123456789', $this->inlineQueryResult->getPhoneNumber());
        $this->inlineQueryResult->setPhoneNumber('+9876543210');
        $this->assertEquals('+9876543210', $this->inlineQueryResult->getPhoneNumber());
    }

    public function testGetSetFirstName()
    {
        $this->assertEquals('Firstname', $this->inlineQueryResult->getFirstName());
        $this->inlineQueryResult->setFirstName('Firstname2');
        $this->assertEquals('Firstname2', $this->inlineQueryResult->getFirstName());
    }

    public function testGetSetLastName()
    {
        $this->assertNull($this->inlineQueryResult->getLastName());
        $this->inlineQueryResult->setLastName('Last Name');
        $this->assertEquals('Last Name', $this->inlineQueryResult->getLastName());

        $this->inlineQueryResult->setLastName(null);
        $this->assertNull($this->inlineQueryResult->getLastName());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setLastName('Lastname');
        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL);
        $this->inlineQueryResult->setThumbWidth(126);
        $this->inlineQueryResult->setThumbHeight(125);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $inlineQueryResult = new InputTextMessageContent('input text');
        $this->inlineQueryResult->setInputMessageContent($inlineQueryResult);

        $resultArray = $this->inlineQueryResult->jsonSerialize();

        $result = json_decode(json_encode($resultArray), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('+0123456789', $result['phone_number']);
        $this->assertEquals('Firstname', $result['first_name']);
        $this->assertEquals('Lastname', $result['last_name']);

        $this->assertArrayHasKey('reply_markup', $result);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(126, $result['thumb_width']);
        $this->assertEquals(125, $result['thumb_height']);
    }
}
