<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultDocument,
    InputMessageContent\InputTextMessageContent,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultDocumentTest extends \PHPUnit_Framework_TestCase
{
    const URL = 'http://example.com/doc.pdf';
    const THUMB_URL = 'http://example.com/img.jpg';

    /**
     * @var InlineQueryResultDocument
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $this->inlineQueryResult = new InlineQueryResultDocument(null, 'Some document', self::URL, 'application/pdf');
    }

    public function testGetSetDocumentUrl()
    {
        $this->assertEquals(self::URL, $this->inlineQueryResult->getDocumentUrl());

        $this->inlineQueryResult->setDocumentUrl(self::URL.'1');

        $this->assertEquals(self::URL.'1', $this->inlineQueryResult->getDocumentUrl());
    }

    public function testGetSetMimeType()
    {
        $this->assertEquals('application/pdf', $this->inlineQueryResult->getMimeType());

        $this->inlineQueryResult->setMimeType('application/zip');

        $this->assertEquals('application/zip', $this->inlineQueryResult->getMimeType());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setCaption('caption');
        $this->inlineQueryResult->setDescription('description');
        $this->inlineQueryResult->setThumbUrl(self::THUMB_URL);
        $this->inlineQueryResult->setThumbWidth(126);
        $this->inlineQueryResult->setThumbHeight(125);
        $this->inlineQueryResult->setReplyMarkup(new ReplyKeyboardMarkup(['1', '2', '3']));

        $inputMessageContent = new InputTextMessageContent('input text');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);

        $resultArray = $this->inlineQueryResult->jsonSerialize();

        $result = json_decode(json_encode($resultArray), true);

        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertEquals('Some document', $result['title']);
        $this->assertEquals(self::URL, $result['document_url']);
        $this->assertEquals('application/pdf', $result['mime_type']);
        $this->assertEquals('document', $result['type']);
        $this->assertEquals('caption', $result['caption']);
        $this->assertEquals('description', $result['description']);

        $this->assertArrayHasKey('reply_markup', $result);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals(self::THUMB_URL, $result['thumb_url']);
        $this->assertEquals(126, $result['thumb_width']);
        $this->assertEquals(125, $result['thumb_height']);
    }
}
