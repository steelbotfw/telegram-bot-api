<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Method\SetWebhook;
use Steelbot\TelegramBotApi\Type\Update;

class SetWebhookTest extends \PHPUnit_Framework_TestCase
{
    const URL = 'https://webhook.url';

    public function testGetParams()
    {
        $method = new SetWebhook(self::URL);

        $this->assertEquals([], $method->getParams());
    }

    public function testBuildResult()
    {
        $method = new SetWebhook(self::URL);

        $result = $method->buildResult(true);

        $this->assertTrue($result);
    }

    public function testJsonSerialize()
    {
        $method = new SetWebhook(self::URL);

        $json = [
            'url' => self::URL
        ];
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);

        $this->assertEquals($json, json_encode($method, JSON_UNESCAPED_UNICODE));
    }

    public function testGetHttpMethod()
    {
        $method = new SetWebhook(self::URL);

        $this->assertEquals(SetWebhook::HTTP_POST, $method->getHttpMethod());
    }

    public function testGetMethodName()
    {
        $method = new SetWebhook(self::URL);

        $this->assertEquals('setWebhook', $method->getMethodName());
    }

    public function testGetSetUrl()
    {
        $method = new SetWebhook(self::URL);

        $this->assertEquals(self::URL, $method->getUrl());

        $method->setUrl(self::URL.'/token');

        $this->assertEquals(self::URL.'/token', $method->getUrl());
    }

    public function testGetSetMaxConnections()
    {
        $method = new SetWebhook(self::URL);

        $this->assertNull($method->getMaxConnections());

        $method->setMaxConnections(42);

        $this->assertEquals(42, $method->getMaxConnections());
    }

    public function testGetSetAllowedUpdates()
    {
        $method = new SetWebhook(self::URL);

        $this->assertNull($method->getAllowedUpdates());

        $method->setAllowedUpdates([
            Update::TYPE_MESSAGE,
            Update::TYPE_INLINE_QUERY
        ]);

        $this->assertCount(2, $method->getAllowedUpdates());
        $this->assertContains(Update::TYPE_MESSAGE, $method->getAllowedUpdates());
        $this->assertContains(Update::TYPE_INLINE_QUERY, $method->getAllowedUpdates());
    }
}
