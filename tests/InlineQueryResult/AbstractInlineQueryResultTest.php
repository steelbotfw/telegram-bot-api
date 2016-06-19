<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\{
    InlineQueryResult\AbstractInlineQueryResult, Type\InlineKeyboardMarkup, Type\InputMessageContentInterface
};

class AbstractInlineQueryResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractInlineQueryResult
     */
    protected $inlineQueryResult;

    public function setUp()
    {
        $inputMessageContent = $this->getMock(InputMessageContentInterface::class);

        /** @var AbstractInlineQueryResult $inlineQueryResult */
        $inlineQueryResult = $this->getMockForAbstractClass(AbstractInlineQueryResult::class, [
            null
        ]);
        $inlineQueryResult->setInputMessageContent($inputMessageContent);

        $reflection = new \ReflectionClass($inlineQueryResult);
        $reflectionProperty = $reflection->getProperty('type');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($inlineQueryResult, 'photo');
        $reflectionProperty->setAccessible(false);

        $this->inlineQueryResult = $inlineQueryResult;
    }

    public function testGetId()
    {
        $this->assertStringStartsWith('steelbot', $this->inlineQueryResult->getId());
    }

    public function testGetType()
    {
        $this->assertEquals('photo', $this->inlineQueryResult->getType());
    }

    public function testJsonSerialize()
    {
        $this->inlineQueryResult->setReplyMarkup(new InlineKeyboardMarkup(['1', '2', '3']));

        $arrayResult = $this->inlineQueryResult->jsonSerialize();
        $result = json_decode(json_encode($arrayResult), true);

        $this->assertEquals('photo', $result['type']);
        $this->assertStringStartsWith('steelbot', $result['id']);
        $this->assertArrayHasKey('input_message_content', $result);
        $this->assertArrayHasKey('reply_markup', $result);
    }
}
