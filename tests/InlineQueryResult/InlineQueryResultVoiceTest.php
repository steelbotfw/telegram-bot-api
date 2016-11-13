<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultVoice,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultVoiceTest extends \PHPUnit_Framework_TestCase
{
    const URL = 'http://voice.url/voice.ogg';

    /**
     * @var InlineQueryResultVoice
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultVoice(null, self::URL, 'Voice Title');
    }

    public function testGetSetVoiceUrl()
    {
        $this->assertEquals(self::URL, $this->inlineQueryResult->getVoiceUrl());

        $this->inlineQueryResult->setVoiceUrl(self::URL.'.ogg');

        $this->assertEquals(self::URL.'.ogg', $this->inlineQueryResult->getVoiceUrl());

        $this->expectException(\TypeError::class);
        $this->inlineQueryResult->setVoiceUrl(null);
    }

    public function testGetSetVoiceDuration()
    {
        $this->assertNull($this->inlineQueryResult->getVoiceDuration());

        $this->inlineQueryResult->setVoiceDuration(123);

        $this->assertEquals(123, $this->inlineQueryResult->getVoiceDuration());

        $this->inlineQueryResult->setVoiceDuration(null);
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setCaption('Voice Caption');
        $this->inlineQueryResult->setVoiceDuration(123);
        $inputMessageContentMock = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult->setInputMessageContent($inputMessageContentMock);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertCount(8, $result);
        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('voice', $result['type']);
        $this->assertEquals('Voice Title', $result['title']);
        $this->assertEquals('Voice Caption', $result['caption']);
        $this->assertEquals(self::URL, $result['voice_url']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(123, $result['voice_duration']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
