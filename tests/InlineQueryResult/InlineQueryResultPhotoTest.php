<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\InlineQueryResultArticle;

class InlineQueryResultPhotoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetThumbUrl()
    {
        $inlineResult = new InlineQueryResultArticle(null, 'Title', 'Text');

        $this->assertNull($inlineResult->getThumbUrl());

        $url = 'http://example.com/img.jpg';
        $inlineResult->setThumbUrl($url);

        $this->assertEquals($url, $inlineResult->getThumbUrl());
    }

    public function testGetSetThumbWidth()
    {
        $inlineResult = new InlineQueryResultArticle(null, 'Title', 'Text');

        $this->assertNull($inlineResult->getThumbWidth());

        $inlineResult->setThumbWidth(126);

        $this->assertEquals(126, $inlineResult->getThumbWidth());
    }

    public function testGetSetThumbHeight()
    {
        $inlineResult = new InlineQueryResultArticle(null, 'Title', 'Text');

        $this->assertNull($inlineResult->getThumbHeight());

        $inlineResult->setThumbHeight(126);

        $this->assertEquals(126, $inlineResult->getThumbHeight());
    }

    public function testGetSetUrl()
    {
        $inlineResult = new InlineQueryResultArticle(null, 'Title', 'Text');

        $this->assertNull($inlineResult->getUrl());

        $inlineResult->setUrl('http://test.com');

        $this->assertEquals('http://test.com', $inlineResult->getUrl());
    }

    public function testJsonSerialize()
    {
        $inlineResult = new InlineQueryResultArticle('steelbot123', 'Test article', 'Text');

        $expectedJsonResult = json_encode([
            'type' => 'article',
            'id' => 'steelbot123',
            'title' => 'Test article',
            'message_text' => 'Text'
        ], JSON_UNESCAPED_UNICODE);
        $jsonResult = json_encode($inlineResult, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($expectedJsonResult, $jsonResult);
    }
}
