<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultAudio,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultAudioTest extends \PHPUnit_Framework_TestCase
{
    const AUDIO_URL = 'http://audio.url/file.mp3';

    /**
     * @var InlineQueryResultAudio
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultAudio(null, self::AUDIO_URL, 'Title');
    }

    public function testGetSetAudioUrl()
    {
        $this->assertEquals(self::AUDIO_URL, $this->inlineQueryResult->getAudioUrl());

        $this->inlineQueryResult->setAudioUrl(self::AUDIO_URL.'1');

        $this->assertEquals(self::AUDIO_URL.'1', $this->inlineQueryResult->getAudioUrl());
    }

    public function testGetSetTitle()
    {
        $this->assertEquals('Title', $this->inlineQueryResult->getTitle());

        $this->inlineQueryResult->setTitle('Another Title');

        $this->assertEquals('Another Title', $this->inlineQueryResult->getTitle());
    }

    public function testGetSetPerformer()
    {
        $this->assertNull($this->inlineQueryResult->getPerformer());

        $this->inlineQueryResult->setPerformer('Performer');

        $this->assertEquals('Performer', $this->inlineQueryResult->getPerformer());

        $this->inlineQueryResult->setPerformer(null);

        $this->assertNull($this->inlineQueryResult->getPerformer());
    }

    public function testGetSetAudioDuration()
    {
        $this->assertNull($this->inlineQueryResult->getAudioDuration());

        $this->inlineQueryResult->setAudioDuration(123);

        $this->assertEquals(123, $this->inlineQueryResult->getAudioDuration());

        $this->inlineQueryResult->setAudioDuration(null);

        $this->assertNull($this->inlineQueryResult->getAudioDuration());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setPerformer('Performer');
        $this->inlineQueryResult->setAudioDuration(234);
        $this->inlineQueryResult->setCaption('AudioCaption');
        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult->setInputMessageContent($inputMessageContentMock);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('audio', $result['type']);
        $this->assertEquals(self::AUDIO_URL, $result['audio_url']);
        $this->assertEquals('Title', $result['title']);
        $this->assertEquals('AudioCaption', $result['caption']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals('Performer', $result['performer']);
        $this->assertEquals(234, $result['audio_duration']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
