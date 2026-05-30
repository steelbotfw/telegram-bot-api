<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\Basic\GetMeUser;

/**
 * @extends AbstractMethod<GetMeUser>
 */
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
    public function buildResult($result): GetMeUser
    {
        return new GetMeUser($result);
    }
}
