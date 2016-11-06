<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultLocation,
    InputMessageContent\InputTextMessageContent,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultLocationTest extends \PHPUnit_Framework_TestCase
{
    const THUMB_URL = 'http://example.com/img.jpg';

    /**
     * @var InlineQueryResultLocation
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultLocation(null, 12.3, 45.6, 'Some location');
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL);
        $this->inlineQueryResult->setThumbWidth(126);
        $this->inlineQueryResult->setThumbHeight(125);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $inputMessageContent = new InputTextMessageContent('input text');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);

        $resultArray = $this->inlineQueryResult->jsonSerialize();

        $result = json_decode(json_encode($resultArray), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('location', $result['type']);
        $this->assertEquals(12.3, $result['latitude']);
        $this->assertEquals(45.6, $result['longitude']);
        $this->assertEquals('Some location', $result['title']);

        $this->assertArrayHasKey('reply_markup', $result);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(126, $result['thumb_width']);
        $this->assertEquals(125, $result['thumb_height']);
    }
}
