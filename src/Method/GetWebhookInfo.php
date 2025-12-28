<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\WebhookInfo;

class GetWebhookInfo extends AbstractMethod
{
    public function getMethodName(): string
    {
        return 'getWebhookInfo';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getParams(): array
    {
        return [];
    }

    /**
     * @param array $result
     *
     * @return WebhookInfo
     */
    public function buildResult($result)
    {
        return new WebhookInfo($result);
    }
}
