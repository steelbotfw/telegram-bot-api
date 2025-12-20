<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\User;

class GetMe extends AbstractMethod
{
    public function getMethodName(): string
    {
        return 'getMe';
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
     * @var array $result
     */
    public function buildResult($result): User
    {
        return new User($result);
    }
}
