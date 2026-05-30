<?php

namespace Steelbot\TelegramBotApi\Method;

/**
 * @extends AbstractMethod<bool>
 */
class DeleteWebhook extends AbstractMethod
{
    public function getMethodName(): string
    {
        return 'deleteWebhook';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getParams(): array
    {
        return [];
    }

    /**
     * @param bool $result
     */
    public function buildResult($result): object|array|bool|int
    {
        return $result;
    }
}
