<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ThumbUrlOptionalTrait;

class ThumbUrlOptionalTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetThumbUrl()
    {
        $mock = $this->getMockForTrait(ThumbUrlOptionalTrait::class);
        $this->assertNull($mock->getThumbUrl());

        $mock->setThumbUrl('http://some.url/example.png');
        $this->assertEquals('http://some.url/example.png', $mock->getThumbUrl());

        $mock->setThumbUrl(null);
        $this->assertNull($mock->getThumbUrl());
    }
}
