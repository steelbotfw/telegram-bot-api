<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\DescriptionTrait;

class DescriptionTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetDescription()
    {
        $mock = $this->getMockForTrait(DescriptionTrait::class);

        $this->assertNull($mock->getDescription());

        $mock->setDescription('Some description');

        $this->assertEquals('Some description', $mock->getDescription());
    }
}
