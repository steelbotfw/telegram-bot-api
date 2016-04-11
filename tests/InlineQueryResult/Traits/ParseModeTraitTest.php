<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\InlineQueryResult\Traits\ParseModeTrait;
use Steelbot\TelegramBotApi\ParseMode;

class ParseModeTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetParseMode()
    {
        $mock = $this->getMockForTrait(ParseModeTrait::class);

        $this->assertNull($mock->getParseMode());

        $mock->setParseMode(ParseMode::MARKDOWN);

        $this->assertEquals(ParseMode::MARKDOWN, $mock->getParseMode());
    }
}
