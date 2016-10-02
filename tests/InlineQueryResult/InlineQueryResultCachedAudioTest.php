<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultCachedAudio,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultCachedAudioTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InlineQueryResultCachedAudio
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult = new InlineQueryResultCachedAudio(null, '123-4');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);
    }

    public function testGetSetAudioFileId()
    {
        $this->assertEquals('123-4', $this->inlineQueryResult->getAudioFileId());

        $this->inlineQueryResult->setAudioFileId('12-34');

        $this->assertEquals('12-34', $this->inlineQueryResult->getAudioFileId());
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
        $this->assertEquals('123-4', $result['audio_file_id']);
        $this->assertEquals('audio', $result['type']);
        $this->assertEquals('title', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals('caption', $result['caption']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
