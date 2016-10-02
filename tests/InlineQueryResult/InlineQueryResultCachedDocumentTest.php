<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\InlineQueryResultCachedDocument,
    Type\InputMessageContentInterface,
    Type\ReplyKeyboardMarkup
};

class InlineQueryResultCachedDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InlineQueryResultCachedDocument
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->createMock(InputMessageContentInterface::class);
        $this->inlineQueryResult = new InlineQueryResultCachedDocument(null, '123-4');
        $this->inlineQueryResult->setInputMessageContent($inputMessageContent);
    }

    public function testGetSetDocumentFileId()
    {
        $this->assertEquals('123-4', $this->inlineQueryResult->getDocumentFileId());

        $this->inlineQueryResult->setDocumentFileId('12-34');

        $this->assertEquals('12-34', $this->inlineQueryResult->getDocumentFileId());
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
        $this->assertEquals('123-4', $result['document_file_id']);
        $this->assertEquals('document', $result['type']);
        $this->assertEquals('title', $result['title']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertEquals('description', $result['description']);
        $this->assertEquals('caption', $result['caption']);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
