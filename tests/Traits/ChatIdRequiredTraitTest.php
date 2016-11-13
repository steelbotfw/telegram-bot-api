<?php

namespace Steelbot\Tests\TelegramBotApi\InlineQueryResult\Traits;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

class ChatIdRequiredTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetChatId()
    {
        $mock = $this->getMockForTrait(ChatIdRequiredTrait::class);

        $mock->setChatId('@somechat');

        $this->assertEquals('@somechat', $mock->getChatId());
    }
}
