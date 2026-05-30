<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;

class ReplyToMessageIdTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetReplyToMessageId()
    {
        $mock = $this->getMockForTrait(ReplyToMessageIdTrait::class);

        $this->assertNull($mock->getReplyToMessageId());

        $mock->setReplyToMessageId(456);

        $this->assertEquals(456, $mock->getReplyToMessageId());
    }
}
