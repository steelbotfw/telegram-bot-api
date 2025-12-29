<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\WebhookInfo;

/**
 * @extends AbstractMethod<WebhookInfo>
 */
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
    public function buildResult($result): object|array|bool|int
    {
        return new WebhookInfo($result);
    }
}
