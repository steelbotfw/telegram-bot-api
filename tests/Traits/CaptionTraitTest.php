<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\CaptionTrait;

class CaptionTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetCaption()
    {
        $mock = $this->getMockForTrait(CaptionTrait::class);

        $this->assertNull($mock->getCaption());

        $mock->setCaption('Some caption');

        $this->assertEquals('Some caption', $mock->getCaption());
    }
}
