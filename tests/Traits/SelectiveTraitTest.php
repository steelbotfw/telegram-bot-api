<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\SelectiveTrait;

class SelectiveTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetSelective()
    {
        $mock = $this->getMockForTrait(SelectiveTrait::class);

        $mock->setSelective(true);

        $this->assertTrue($mock->getSelective());
    }
}
