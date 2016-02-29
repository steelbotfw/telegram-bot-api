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

    public function buildResult(array $result)
    {
        return new User($result);
    }

    public function jsonSerialize()
    {
        return [];
    }
}
