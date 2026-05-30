<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\TitleTrait;

class TitleTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetTitle()
    {
        $mock = $this->getMockForTrait(TitleTrait::class);

        $this->assertNull($mock->getTitle());

        $mock->setTitle('Some title');

        $this->assertEquals('Some title', $mock->getTitle());
    }
}
