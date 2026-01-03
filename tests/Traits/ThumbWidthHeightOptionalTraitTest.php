<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ThumbWidthHeightOptionalTrait;

class ThumbWidthHeightOptionalTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetThumbWidth()
    {
        $mock = $this->getMockForTrait(ThumbWidthHeightOptionalTrait::class);
        $this->assertNull($mock->getThumbWidth());

        $mock->setThumbWidth(123);
        $this->assertEquals(123, $mock->getThumbWidth());

        $mock->setThumbWidth(null);
        $this->assertNull($mock->getThumbWidth());
    }

    public function testGetSetThumbHeight()
    {
        $mock = $this->getMockForTrait(ThumbWidthHeightOptionalTrait::class);
        $this->assertNull($mock->getThumbHeight());

        $mock->setThumbHeight(234);
        $this->assertEquals(234, $mock->getThumbHeight());

        $mock->setThumbHeight(null);
        $this->assertNull($mock->getThumbHeight());
    }
}
