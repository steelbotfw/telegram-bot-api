<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\TitleRequiredTrait;

class TitleRequiredTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetTitle()
    {
        $mock = $this->getMockForTrait(TitleRequiredTrait::class);
        $mock->setTitle('Some title');

        $this->assertEquals('Some title', $mock->getTitle());
    }

    public function testGetTitleNullFails()
    {
        $mock = $this->getMockForTrait(TitleRequiredTrait::class);

        $this->expectException(\TypeError::class);
        $mock->getTitle();
    }

    public function testSetTitleNullFails()
    {
        $mock = $this->getMockForTrait(TitleRequiredTrait::class);

        $this->expectException(\TypeError::class);

        $mock->setTitle();
        $mock->setTitle(null);
    }
}
