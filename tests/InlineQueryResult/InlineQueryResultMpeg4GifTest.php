<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultMpeg4Gif;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class InlineQueryResultMpeg4GifTest extends \PHPUnit_Framework_TestCase
{
    const URL = 'http://mpeg.url/file.mpeg';
    const THUMB_URL = 'http://thumb.url/thumb/png';

    /**
     * @var InlineQueryResultMpeg4Gif
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultMpeg4Gif(null, self::URL, self::THUMB_URL);
    }

    public function testGetSetMpeg4GifUrl()
    {
        $this->assertEquals(self::URL, $this->inlineQueryResult->getMpeg4Url());

        $this->inlineQueryResult->setMpeg4Url(self::URL.'.com');

        $this->assertEquals(self::URL.'.com', $this->inlineQueryResult->getMpeg4Url());
    }

    public function testGetSetMpeg4GifWidth()
    {
        $this->assertNull($this->inlineQueryResult->getMpeg4Width());

        $this->inlineQueryResult->setMpeg4Width(123);

        $this->assertEquals(123, $this->inlineQueryResult->getMpeg4Width());
    }

    public function testGetSetMpeg4height()
    {
        $this->assertNull($this->inlineQueryResult->getMpeg4height());

        $this->inlineQueryResult->setMpeg4height(123);

        $this->assertEquals(123, $this->inlineQueryResult->getMpeg4height());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setTitle('Mpeg4GifTitle');
        $this->inlineQueryResult->setCaption('Mpeg4GifCaption');
        $this->inlineQueryResult->setMpeg4width(200);
        $this->inlineQueryResult->setMpeg4height(100);
        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult->setInputMessageContent($inputMessageContentMock);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertCount(10, $result);
        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('mpeg4_gif', $result['type']);
        $this->assertEquals('Mpeg4GifTitle', $result['title']);
        $this->assertEquals('Mpeg4GifCaption', $result['caption']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::URL, $result['mpeg4_url']);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(200, $result['mpeg4_width']);
        $this->assertEquals(100, $result['mpeg4_height']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
