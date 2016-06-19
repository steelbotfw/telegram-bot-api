<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\CaptionTrait;

class CaptionTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetCaption()
    {
        $mock = $this->getMockForTrait(CaptionTrait::class);

        $this->assertNull($mock->getCaption());

        $mock->setCaption('Some caption');

        $this->assertEquals('Some caption', $mock->getCaption());
    }
}
