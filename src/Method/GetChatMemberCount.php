<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

/**
 * @extends AbstractMethod<int>
 */
class GetChatMemberCount extends AbstractMethod
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
        return 'getChatMemberCount';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
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
    public function buildResult($result): object|array|bool|int
    {
        return $result;
    }
}
