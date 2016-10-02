<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultCachedVideo,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultCachedVideoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InlineQueryResultCachedVideo
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult = new InlineQueryResultCachedVideo(null, '123-4');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);
    }

    public function testGetSetVideoFileId()
    {
        $this->assertEquals('123-4', $this->inlineQueryResult->getVideoFileId());

        $this->inlineQueryResult->setVideoFileId('12-34');

        $this->assertEquals('12-34', $this->inlineQueryResult->getVideoFileId());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setTitle('title');
        $this->inlineQueryResult->setDescription('description');
        $this->inlineQueryResult->setCaption('caption');
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertNotEmpty($result['id']);
        $this->assertEquals('123-4', $result['video_file_id']);
        $this->assertEquals('video', $result['type']);
        $this->assertEquals('title', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals('description', $result['description']);
        $this->assertEquals('caption', $result['caption']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
