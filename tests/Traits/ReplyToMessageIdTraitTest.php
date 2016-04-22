<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;

class ReplyToMessageIdTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetReplyToMessageId()
    {
        $mock = $this->getMockForTrait(ReplyToMessageIdTrait::class);

        $this->assertNull($mock->getReplyToMessageId());

        $mock->setReplyToMessageId(456);

        $this->assertEquals(456, $mock->getReplyToMessageId());
    }
}
