<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultCachedPhoto,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultCachedPhotoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InlineQueryResultCachedPhoto
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->getMock(InputMessageContentInterface::class);
        $this->inlineQueryResult = new InlineQueryResultCachedPhoto(null, '123-4');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);
    }

    public function testGetSetPhotoFileId()
    {
        $this->assertEquals('123-4', $this->inlineQueryResult->getPhotoFileId());

        $this->inlineQueryResult->setPhotoFileId('12-34');

        $this->assertEquals('12-34', $this->inlineQueryResult->getPhotoFileId());
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
        $this->assertEquals('123-4', $result['photo_file_id']);
        $this->assertEquals('photo', $result['type']);
        $this->assertEquals('title', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals('description', $result['description']);
        $this->assertEquals('caption', $result['caption']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
