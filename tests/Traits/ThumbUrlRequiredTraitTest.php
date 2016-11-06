<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ThumbUrlRequiredTrait;

class ThumbUrlRequiredTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetTitle()
    {
        $mock = $this->getMockForTrait(ThumbUrlRequiredTrait::class);
        $mock->setThumbUrl('http://some.url/example.png');

        $this->assertEquals('http://some.url/example.png', $mock->getThumbUrl());
    }

    public function testGetTitleNullFails()
    {
        $mock = $this->getMockForTrait(ThumbUrlRequiredTrait::class);

        $this->expectException(\TypeError::class);
        $mock->getThumbUrl();
    }

    public function testSetTitleNullFails()
    {
        $mock = $this->getMockForTrait(ThumbUrlRequiredTrait::class);

        $this->expectException(\TypeError::class);

        $mock->setThumbUrl();
        $mock->setThumbUrl(null);
    }
}
