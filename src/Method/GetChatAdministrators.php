<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Type\ChatMember;

/**
 * @extends AbstractMethod<ChatMember>
 */
class GetChatAdministrators extends AbstractMethod
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
        return 'getChatAdministrators';
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
     * @param array $result
     *
     * @return ChatMember[]
     */
    public function buildResult($result): object|array|bool|int
    {
        $chatMembers = [];

        foreach ($result as $item) {
            $chatMembers[] = new ChatMember($item);
        }

        return $chatMembers;
    }
}
