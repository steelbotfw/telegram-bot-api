<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultCachedSticker;

class InlineQueryResultCachedStickerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetStickerFileId()
    {
        $inlineResult = new InlineQueryResultCachedSticker(null, '1234');

        $inlineResult->setStickerFileId('12345');

        $this->assertEquals('12345', $inlineResult->getStickerFileId());
    }

    public function testJsonSerialize()
    {
        $inlineResult = new InlineQueryResultCachedSticker('steelbot123', '1234');

        $expectedJsonResult = json_encode([
            'type' => 'sticker',
            'id' => 'steelbot123',
            'sticker_file_id' => '1234'
        ], JSON_UNESCAPED_UNICODE);
        $jsonResult = json_encode($inlineResult, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($expectedJsonResult, $jsonResult);
    }
}
