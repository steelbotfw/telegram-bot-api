<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Type\ChatMember;

class GetChatAdministrators extends AbstractMethod
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
        return 'getChatAdministrators';
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
     * @param array $result
     *
     * @return ChatMember[]
     */
    public function buildResult($result)
    {
        $chatMembers = [];

        foreach ($result as $item) {
            $chatMembers[] = new ChatMember($item);
        }

        return $chatMembers;
    }
}
