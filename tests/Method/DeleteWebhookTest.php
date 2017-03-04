<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Method\DeleteWebhook;

class DeleteWebhookTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new DeleteWebhook();

        $this->assertEquals('deleteWebhook', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new DeleteWebhook();

        $this->assertEquals(AbstractMethod::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new DeleteWebhook();

        $this->assertEquals([], $method->getParams());
    }

    public function testBuildResult()
    {
        $method = new DeleteWebhook();
        $true = $method->buildResult(true);

        $this->assertTrue($true);
    }
}
