<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;

class DisableNotificationTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetDisableNotification()
    {
        $mock = $this->getMockForTrait(DisableNotificationTrait::class);

        $this->assertNull($mock->getDisableNotification());

        $mock->setDisableNotification(true);

        $this->assertTrue($mock->getDisableNotification());
    }
}
