<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

class GetChatMembersCount extends AbstractMethod
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
        return 'getChatMembersCount';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_GET;
    }

    public function getParams(): array
    {
        return [
            'chat_id' => $this->chatId
        ];
    }

    /**
     * @param int $result
     *
     * @return int
     */
    public function buildResult($result)
    {
        return $result;
    }
}
