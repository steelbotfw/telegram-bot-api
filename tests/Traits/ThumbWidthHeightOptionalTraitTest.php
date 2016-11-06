<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ThumbWidthHeightOptionalTrait;

class ThumbWidthHeightOptionalTraitTest extends \PHPUnit_Framework_TestCase
{
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
