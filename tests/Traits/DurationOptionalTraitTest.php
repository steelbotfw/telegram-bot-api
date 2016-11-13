<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\DurationOptionalTrait;

class DurationOptionalTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetDuration()
    {
        $mock = $this->getMockForTrait(DurationOptionalTrait::class);
        $this->assertNull($mock->getDuration());

        $mock->setDuration(42);
        $this->assertEquals(42, $mock->getDuration());

        $mock->setDuration(null);
        $this->assertNull($mock->getDuration());
    }
}
