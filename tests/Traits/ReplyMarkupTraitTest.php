<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;

class ReplyMarkupTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetParseMode()
    {
        $mock = $this->getMockForTrait(ReplyMarkupTrait::class);

        $markupJson = json_encode([1,2,3, '4']);
        $mock->setReplyMarkup($markupJson);

        $this->assertEquals($markupJson, $mock->getReplyMarkup());
    }
}
