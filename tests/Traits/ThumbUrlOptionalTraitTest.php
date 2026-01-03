<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ThumbUrlOptionalTrait;

class ThumbUrlOptionalTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetThumbUrl()
    {
        $mock = $this->getMockForTrait(ThumbUrlOptionalTrait::class);
        $this->assertNull($mock->getThumbUrl());

        $mock->setThumbUrl('http://some.url/example.png');
        $this->assertEquals('http://some.url/example.png', $mock->getThumbUrl());

        $mock->setThumbUrl(null);
        $this->assertNull($mock->getThumbUrl());
    }
}
