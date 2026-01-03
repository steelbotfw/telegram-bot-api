<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\UserIdRequiredTrait;

class UserIdRequiredTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetUserId()
    {
        $mock = $this->getMockForTrait(UserIdRequiredTrait::class);

        $mock->setUserId(42);

        $this->assertEquals(42, $mock->getUserId());

        $this->expectException(\TypeError::class);

        $mock->setUserId(null);
    }
}
