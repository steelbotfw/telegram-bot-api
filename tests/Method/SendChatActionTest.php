<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use PHPUnit\Framework\TestCase;
use Steelbot\TelegramBotApi\Method\SendChatAction;
use Steelbot\TelegramBotApi\Type\Message;

class SendChatActionTest extends TestCase
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Need to refactor tests');
    }

    public function testBuildResult()
    {
        $method = new SendChatAction(123, SendChatAction::ACTION_TYPING);

        $resultData = true;
        $result = $method->buildResult($resultData);

        $this->assertTrue($result);
    }
}
