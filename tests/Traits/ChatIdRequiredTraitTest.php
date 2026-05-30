<?php

namespace Steelbot\Tests\TelegramBotApi\Traits;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

class ChatIdRequiredTraitTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testGetSetChatId()
    {
        $mock = $this->getMockForTrait(ChatIdRequiredTrait::class);

        $mock->setChatId('@somechat');

        $this->assertEquals('@somechat', $mock->getChatId());
    }
}
