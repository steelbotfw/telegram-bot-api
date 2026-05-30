<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;

class DisableNotificationTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetDisableNotification()
    {
        $mock = $this->getMockForTrait(DisableNotificationTrait::class);

        $this->assertNull($mock->getDisableNotification());

        $mock->setDisableNotification(true);

        $this->assertTrue($mock->getDisableNotification());
    }
}
