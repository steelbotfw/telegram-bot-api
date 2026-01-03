<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Type\ReplyKeyboardMarkup;

class ReplyMarkupTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetParseMode()
    {
        $mock = $this->getMockForTrait(ReplyMarkupTrait::class);

        $markup = new ReplyKeyboardMarkup(['1', '2']);
        $mock->setReplyMarkup($markup);

        $this->assertSame($markup, $mock->getReplyMarkup());
    }
}
