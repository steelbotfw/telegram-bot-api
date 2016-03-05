<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SendChatAction;
use Steelbot\TelegramBotApi\Type\Message;

class SendChatActionTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildResult()
    {
        $method = new SendChatAction(123, SendChatAction::ACTION_TYPING);

        $resultData = true;
        $result = $method->buildResult($resultData);

        $this->assertTrue($result);
    }
}
