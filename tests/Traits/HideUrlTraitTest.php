<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\HideUrlTrait;

class HideUrlTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetHideUrl()
    {
        $mock = $this->getMockForTrait(HideUrlTrait::class);

        $this->assertNull($mock->getHideUrl());

        $mock->setHideUrl(true);

        $this->assertTrue($mock->getHideUrl());
    }
}
