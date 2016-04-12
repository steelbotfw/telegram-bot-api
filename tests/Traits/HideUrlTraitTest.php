<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\HideUrlTrait;

class HideUrlTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetHideUrl()
    {
        $mock = $this->getMockForTrait(HideUrlTrait::class);

        $this->assertNull($mock->getHideUrl());

        $mock->setHideUrl(true);

        $this->assertTrue($mock->getHideUrl());
    }
}
