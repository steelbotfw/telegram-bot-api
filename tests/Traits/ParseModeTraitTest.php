<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ParseModeTrait;
use Steelbot\TelegramBotApi\ParseMode;

class ParseModeTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetParseMode()
    {
        $mock = $this->getMockForTrait(ParseModeTrait::class);

        $this->assertNull($mock->getParseMode());

        $mock->setParseMode(ParseMode::MARKDOWN);

        $this->assertEquals(ParseMode::MARKDOWN, $mock->getParseMode());
    }
}
