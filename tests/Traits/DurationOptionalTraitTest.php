<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\DurationOptionalTrait;

class DurationOptionalTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

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
