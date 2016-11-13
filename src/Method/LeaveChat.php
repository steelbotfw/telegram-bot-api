<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

class LeaveChat extends AbstractMethod
{
    use ChatIdRequiredTrait;

    /**
     * GetChatMembersCount constructor.
     *
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

    public function getHttpMethod(): string
    {
        return self::HTTP_POST;
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
    public function buildResult($result)
    {
        return $result;
    }
}
