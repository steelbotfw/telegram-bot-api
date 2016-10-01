<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultCachedMpeg4Gif,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultCachedMpeg4GifTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InlineQueryResultCachedMpeg4Gif
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult = new InlineQueryResultCachedMpeg4Gif(null, '123-4');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);
    }

    public function testGetSetMpeg4FileId()
    {
        $this->assertEquals('123-4', $this->inlineQueryResult->getMpeg4FileId());

        $this->inlineQueryResult->setMpeg4FileId('12-34');

        $this->assertEquals('12-34', $this->inlineQueryResult->getMpeg4FileId());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setTitle('title');
        $this->inlineQueryResult->setCaption('caption');
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertNotEmpty($result['id']);
        $this->assertEquals('123-4', $result['mpeg4_file_id']);
        $this->assertEquals('mpeg4_gif', $result['type']);
        $this->assertEquals('title', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals('caption', $result['caption']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
