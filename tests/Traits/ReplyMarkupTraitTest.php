<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class ReplyMarkupTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetParseMode()
    {
        $mock = $this->getMockForTrait(ReplyMarkupTrait::class);

        $markup = new ReplyKeyboardMarkup(['1', '2']);
        $mock->setReplyMarkup($markup);

        $this->assertSame($markup, $mock->getReplyMarkup());
    }
}
