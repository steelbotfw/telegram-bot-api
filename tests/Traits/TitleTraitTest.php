<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\TitleTrait;

class TitleTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetTitle()
    {
        $mock = $this->getMockForTrait(TitleTrait::class);

        $this->assertNull($mock->getTitle());

        $mock->setTitle('Some title');

        $this->assertEquals('Some title', $mock->getTitle());
    }
}
