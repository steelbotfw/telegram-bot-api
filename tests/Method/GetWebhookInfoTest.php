<?php

namespace Steelbot\Tests\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Method\AbstractMethod,
    Method\GetWebhookInfo,
    Type\WebhookInfo
};

class GetWebhookInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodName()
    {
        $method = new GetWebhookInfo();

        $this->assertEquals('getWebhookInfo', $method->getMethodName());
    }

    public function testGetHttpMethod()
    {
        $method = new GetWebhookInfo();

        $this->assertEquals(AbstractMethod::HTTP_GET, $method->getHttpMethod());
    }

    public function testGetParams()
    {
        $method = new GetWebhookInfo();

        $this->assertEquals([], $method->getParams());
    }

    public function testBuildResult()
    {
        $method = new GetWebhookInfo();

        $result = [
            'url' => 'https://url.com',
            'has_custom_certificate' => false,
            'pending_update_count' => 0,
        ];
        $webhookInfo = $method->buildResult($result);

        $this->assertInstanceOf(WebhookInfo::class, $webhookInfo);
    }
}
