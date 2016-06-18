<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\ChatMember;

class GetChatAdministrators extends AbstractMethod
{
    /**
     * @var int|string
     */
    protected $chatId;

    /**
     * GetChatMembersCount constructor.
     *
     * @param int|string $chatId
     */
    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    /**
     * @return int|string
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @param int|string $chatId
     *
     * @return GetChatMembersCount
     */
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;

        return $this;
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
