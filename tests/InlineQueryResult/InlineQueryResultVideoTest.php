<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultVideo;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class InlineQueryResultVideoTest extends \PHPUnit_Framework_TestCase
{
    const URL = 'http://mpeg.url/file.mpeg';
    const THUMB_URL = 'http://thumb.url/thumb.png';

    /**
     * @var InlineQueryResultVideo
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultVideo(null, self::URL, 'application/mpeg', self::THUMB_URL, 'Video Title');
    }

    public function testGetSetVideoUrl()
    {
        $this->assertEquals(self::URL, $this->inlineQueryResult->getVideoUrl());

        $this->inlineQueryResult->setVideoUrl(self::URL.'.com');

        $this->assertEquals(self::URL.'.com', $this->inlineQueryResult->getVideoUrl());
    }

    public function testGetSetVideoWidth()
    {
        $this->assertNull($this->inlineQueryResult->getVideoWidth());

        $this->inlineQueryResult->setVideoWidth(123);

        $this->assertEquals(123, $this->inlineQueryResult->getVideoWidth());
    }

    public function testGetSetVideoHeight()
    {
        $this->assertNull($this->inlineQueryResult->getVideoHeight());

        $this->inlineQueryResult->setVideoHeight(123);

        $this->assertEquals(123, $this->inlineQueryResult->getVideoHeight());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setCaption('Video Caption');
        $this->inlineQueryResult->setDescription('Video Description');
        $this->inlineQueryResult->setVideoWidth(200);
        $this->inlineQueryResult->setVideoHeight(100);
        $this->inlineQueryResult->setVideoDuration(122);
        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult->setInputMessageContent($inputMessageContentMock);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertCount(13, $result);
        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('video', $result['type']);
        $this->assertEquals('Video Title', $result['title']);
        $this->assertEquals('application/mpeg', $result['mime_type']);
        $this->assertEquals('Video Caption', $result['caption']);
        $this->assertEquals('Video Description', $result['description']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::URL, $result['video_url']);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(200, $result['video_width']);
        $this->assertEquals(100, $result['video_height']);
        $this->assertEquals(122, $result['video_duration']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
