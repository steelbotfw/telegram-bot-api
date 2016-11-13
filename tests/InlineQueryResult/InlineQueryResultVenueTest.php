<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultVenue,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultVenueTest extends \PHPUnit_Framework_TestCase
{
    const THUMB_URL = 'http://thumb.url/thumb.png';

    /**
     * @var InlineQueryResultVenue
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultVenue(null, 12.3, 45.6, 'Venue Title', 'Venue Address');
    }

    public function testGetSetAddress()
    {
        $this->assertEquals('Venue Address', $this->inlineQueryResult->getAddress());

        $this->inlineQueryResult->setAddress('Venue Address 1');

        $this->assertEquals('Venue Address 1', $this->inlineQueryResult->getAddress());

        $this->expectException(\TypeError::class);
        $this->inlineQueryResult->setAddress(null);
    }

    public function testGetSetFoursquareId()
    {
        $this->assertNull($this->inlineQueryResult->getFoursquareId());

        $this->inlineQueryResult->setFoursquareId('Foursquare-id');

        $this->assertEquals('Foursquare-id', $this->inlineQueryResult->getFoursquareId());

        $this->inlineQueryResult->setFoursquareId(null);
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setFoursquareId('FoursquareId');

        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL);
        $this->inlineQueryResult->setThumbWidth(123);
        $this->inlineQueryResult->setThumbHeight(234);
        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult->setInputMessageContent($inputMessageContentMock);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertCount(12, $result);
        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('venue', $result['type']);
        $this->assertEquals(12.3, $result['latitude']);
        $this->assertEquals(45.6, $result['longitude']);
        $this->assertEquals('Venue Title', $result['title']);
        $this->assertEquals('Venue Address', $result['address']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(123, $result['thumb_width']);
        $this->assertEquals(234, $result['thumb_height']);
        $this->assertArrayHasKey('reply_markup', $result);
        $this->assertEquals('FoursquareId', $result['foursquare_id']);
    }
}
