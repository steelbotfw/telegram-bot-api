<?php

namespace Steelbot\TelegramBotApi\Method;

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
     *
     * @return bool
     */
    public function buildResult($result)
    {
        return $result;
    }
}
