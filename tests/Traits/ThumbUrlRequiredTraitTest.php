<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ThumbUrlRequiredTrait;

class ThumbUrlRequiredTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetTitle()
    {
        $mock = $this->getMockForTrait(ThumbUrlRequiredTrait::class);
        $mock->setThumbUrl('http://some.url/example.png');

        $this->assertEquals('http://some.url/example.png', $mock->getThumbUrl());
    }

    public function testGetTitleNullFails()
    {
        $mock = $this->getMockForTrait(ThumbUrlRequiredTrait::class);

        $this->expectException(\TypeError::class);
        $mock->getThumbUrl();
    }

    public function testSetTitleNullFails()
    {
        $mock = $this->getMockForTrait(ThumbUrlRequiredTrait::class);

        $this->expectException(\TypeError::class);

        $mock->setThumbUrl();
        $mock->setThumbUrl(null);
    }
}
