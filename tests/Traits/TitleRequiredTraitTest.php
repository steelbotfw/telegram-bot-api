<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\TitleRequiredTrait;

class TitleRequiredTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetTitle()
    {
        $mock = $this->getMockForTrait(TitleRequiredTrait::class);
        $mock->setTitle('Some title');

        $this->assertEquals('Some title', $mock->getTitle());
    }

    public function testGetTitleNullFails()
    {
        $mock = $this->getMockForTrait(TitleRequiredTrait::class);

        $this->expectException(\TypeError::class);
        $mock->getTitle();
    }

    public function testSetTitleNullFails()
    {
        $mock = $this->getMockForTrait(TitleRequiredTrait::class);

        $this->expectException(\TypeError::class);

        $mock->setTitle();
        $mock->setTitle(null);
    }
}
