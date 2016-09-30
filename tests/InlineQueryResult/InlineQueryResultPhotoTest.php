<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultPhoto;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class InlineQueryResultPhotoTest extends \PHPUnit_Framework_TestCase
{
    const PHOTO_URL = 'http://photo.url';
    const THUMB_URL = 'http://thumb.url';

    /**
     * @var InlineQueryResultPhoto
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultPhoto(null, self::PHOTO_URL, self::THUMB_URL);
    }

    public function testGetSetPhotoUrl()
    {
        $this->assertEquals(self::PHOTO_URL, $this->inlineQueryResult->getPhotoUrl());

        $this->inlineQueryResult->setPhotoUrl(self::PHOTO_URL.'.com');

        $this->assertEquals(self::PHOTO_URL.'.com', $this->inlineQueryResult->getPhotoUrl());
    }

    public function testGetSetThumbUrl()
    {
        $this->assertEquals(self::THUMB_URL, $this->inlineQueryResult->getThumbUrl());

        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL.'.com');

        $this->assertEquals(self::THUMB_URL.'.com', $this->inlineQueryResult->getThumbUrl());
    }

    public function testGetSetPhotoWidth()
    {
        $this->assertNull($this->inlineQueryResult->getPhotoWidth());

        $this->inlineQueryResult->setPhotoWidth(123);

        $this->assertEquals(123, $this->inlineQueryResult->getPhotoWidth());
    }

    public function testGetSetPhotoHeight()
    {
        $this->assertNull($this->inlineQueryResult->getPhotoHeight());

        $this->inlineQueryResult->setPhotoHeight(123);

        $this->assertEquals(123, $this->inlineQueryResult->getPhotoHeight());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setTitle('PhotoTitle');
        $this->inlineQueryResult->setCaption('PhotoCaption');
        $this->inlineQueryResult->setDescription('PhotoDescription');
        $this->inlineQueryResult->setPhotoWidth(200);
        $this->inlineQueryResult->setPhotoHeight(100);
        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult->setInputMessageContent($inputMessageContentMock);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertNotEmpty($result['id']);
        $this->assertEquals('photo', $result['type']);
        $this->assertEquals('PhotoTitle', $result['title']);
        $this->assertEquals('PhotoCaption', $result['caption']);
        $this->assertEquals('PhotoDescription', $result['description']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::PHOTO_URL, $result['photo_url']);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(200, $result['photo_width']);
        $this->assertEquals(100, $result['photo_height']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
