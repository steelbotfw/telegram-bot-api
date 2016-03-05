<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\User;

class GetMe extends AbstractMethod
{
    public function getMethodName(): string
    {
        return 'getMe';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_GET;
    }

    public function getParams(): array
    {
        return [];
    }

    /**
     * @param array $result
     *
     * @return User
     */
    public function buildResult($result)
    {
        return new User($result);
    }
}
