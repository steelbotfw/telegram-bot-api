<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultCachedPhoto;

class InlineQueryResultCachedPhotoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetPhotoFileId()
    {
        $inlineResult = new InlineQueryResultCachedPhoto(null, '123-4');

        $this->assertEquals('123-4', $inlineResult->getPhotoFileId());

        $inlineResult->setPhotoFileId('12-34');

        $this->assertEquals('12-34', $inlineResult->getPhotoFileId());
    }

    public function testGetSetTitle()
    {
        $inlineResult = new InlineQueryResultCachedPhoto(null, '123-4');

        $this->assertNull($inlineResult->getTitle());

        $inlineResult->setTitle('Title');

        $this->assertEquals('Title', $inlineResult->getTitle());
    }

    public function testGetSetCaption()
    {
        $inlineResult = new InlineQueryResultCachedPhoto(null, '123-4');

        $this->assertNull($inlineResult->getCaption());

        $inlineResult->setCaption('Caption');

        $this->assertEquals('Caption', $inlineResult->getCaption());
    }

    /**
     * @todo add tests for optional fields
     */
    public function testJsonSerialize()
    {
        $inlineResult = new InlineQueryResultCachedPhoto('steelbot123', '123-4');

        $expectedJsonResult = json_encode([
            'type' => 'photo',
            'id' => 'steelbot123',
            'photo_file_id' => '123-4'
        ], JSON_UNESCAPED_UNICODE);
        $jsonResult = json_encode($inlineResult, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($expectedJsonResult, $jsonResult);
    }
}
