<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\UserIdRequiredTrait;

class UserIdRequiredTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetUserId()
    {
        $mock = $this->getMockForTrait(UserIdRequiredTrait::class);

        $mock->setUserId(42);

        $this->assertEquals(42, $mock->getUserId());

        $this->expectException(\TypeError::class);

        $mock->setUserId(null);
    }
}
