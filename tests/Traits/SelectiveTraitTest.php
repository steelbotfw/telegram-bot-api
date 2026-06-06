<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\SelectiveTrait;

class SelectiveTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSetSelective()
    {
        $mock = $this->getMockForTrait(SelectiveTrait::class);

        $mock->setSelective(true);

        $this->assertTrue($mock->getSelective());
    }
}
