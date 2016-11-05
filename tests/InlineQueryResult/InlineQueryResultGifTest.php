<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultGif, InputMessageContent\InputTextMessageContent, Type\InputMessageContentInterface, Type\ReplyKeyboardMarkup
};

class InlineQueryResultGifTest extends \PHPUnit_Framework_TestCase
{
    const THUMB_URL = 'http://example.com/pic.jpg';
    const URL = 'http://example.com/pic.gif';

    /**
     * @var InlineQueryResultGif
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultGif(null, self::URL, self::THUMB_URL);
    }

    public function testGetSetGifUrl()
    {
        $this->assertEquals(self::URL, $this->inlineQueryResult->getGifUrl());

        $this->inlineQueryResult->setGifUrl(self::URL.'1');

        $this->assertEquals(self::URL.'1', $this->inlineQueryResult->getGifUrl());
    }

    public function testGetSetThumbUrl()
    {
        $this->assertEquals(self::THUMB_URL, $this->inlineQueryResult->getThumbUrl());

        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL.'1');

        $this->assertEquals(self::THUMB_URL.'1', $this->inlineQueryResult->getThumbUrl());
    }

    public function testGetSetGifWidth()
    {
        $this->assertNull($this->inlineQueryResult->getGifWidth());

        $this->inlineQueryResult->setGifWidth(126);

        $this->assertEquals(126, $this->inlineQueryResult->getGifWidth());

        $this->inlineQueryResult->setGifWidth();

        $this->assertNull($this->inlineQueryResult->getGifWidth());
    }

    public function testGetSetGifHeight()
    {
        $this->assertNull($this->inlineQueryResult->getGifHeight());

        $this->inlineQueryResult->setGifHeight(126);

        $this->assertEquals(126, $this->inlineQueryResult->getGifHeight());

        $this->inlineQueryResult->setGifHeight();

        $this->assertNull($this->inlineQueryResult->getGifHeight());
    }

    public function testJsonSerialize()
    {
        $inputMessageContent = new InputTextMessageContent('input text');

        $this->inlineQueryResult->setGifWidth(126);
        $this->inlineQueryResult->setGifHeight(125);
        $this->inlineQueryResult->setTitle('GifTitle');
        $this->inlineQueryResult->setCaption('GifCaption');
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);

        $resultArray = $this->inlineQueryResult->jsonSerialize();

        $result = json_decode(json_encode($resultArray), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('gif', $result['type']);
        $this->assertEquals('GifTitle', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(126, $result['gif_width']);
        $this->assertEquals(125, $result['gif_height']);
        $this->assertEquals(self::URL, $result['gif_url']);
        $this->assertEquals('GifCaption', $result['caption']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
