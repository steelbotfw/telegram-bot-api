<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultArticle,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultArticleTest extends \PHPUnit_Framework_TestCase
{
    const THUMB_URL = 'http://example.com/img.jpg';
    const URL = 'http://test.com';

    /**
     * @var InlineQueryResultArticle
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult = new InlineQueryResultArticle(null, 'ArticleTitle', $inputMessageContent);
    }

    public function testGetSetThumbUrl()
    {
        $this->assertNull($this->inlineQueryResult->getThumbUrl());

        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL);

        $this->assertEquals(self::THUMB_URL, $this->inlineQueryResult->getThumbUrl());
    }

    public function testGetSetThumbWidth()
    {
        $this->assertNull($this->inlineQueryResult->getThumbWidth());

        $this->inlineQueryResult->setThumbWidth(126);

        $this->assertEquals(126, $this->inlineQueryResult->getThumbWidth());
    }

    public function testGetSetThumbHeight()
    {
        $this->assertNull($this->inlineQueryResult->getThumbHeight());

        $this->inlineQueryResult->setThumbHeight(126);

        $this->assertEquals(126, $this->inlineQueryResult->getThumbHeight());
    }

    public function testGetSetUrl()
    {
        $this->assertNull($this->inlineQueryResult->getUrl());

        $this->inlineQueryResult->setUrl(self::URL);

        $this->assertEquals(self::URL, $this->inlineQueryResult->getUrl());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL);
        $this->inlineQueryResult->setThumbWidth(126);
        $this->inlineQueryResult->setThumbHeight(125);
        $this->inlineQueryResult->setUrl(self::URL);
        $this->inlineQueryResult->setDescription('description');
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $resultArray = $this->inlineQueryResult->jsonSerialize();

        $result = json_decode(json_encode($resultArray), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertNotEmpty($result['id']);
        $this->assertEquals('article', $result['type']);
        $this->assertEquals('ArticleTitle', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(126, $result['thumb_width']);
        $this->assertEquals(125, $result['thumb_height']);
        $this->assertEquals(self::URL, $result['url']);
        $this->assertEquals('description', $result['description']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
