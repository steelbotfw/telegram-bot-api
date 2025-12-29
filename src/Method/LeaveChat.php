<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

/**
 * @extends AbstractMethod<bool>
 */
class LeaveChat extends AbstractMethod
{
    use ChatIdRequiredTrait;

    /**
     * @param int|string $chatId
     */
    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function getMethodName(): string
    {
        return 'leaveChat';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getParams(): array
    {
        return [
            'chat_id' => $this->chatId
        ];
    }

    /**
     * @param bool $result
     *
     * @return bool
     */
    public function buildResult($result): object|array|bool|int
    {
        return $result;
    }
}
