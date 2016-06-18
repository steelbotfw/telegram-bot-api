<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\ChatMember;
use Steelbot\TelegramBotApi\Type\User;

class GetChatMember extends AbstractMethod
{
    /**
     * @var int|string
     */
    protected $chatId;

    /**
     * @var int
     */
    protected $userId;

    /**
     * GetChatMembersCount constructor.
     *
     * @param int|string $chatId
     */
    public function __construct($chatId, $userId)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
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

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return $this
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getMethodName(): string
    {
        return 'getChatMember';
    }

    public function getHttpMethod(): string
    {
        return self::HTTP_GET;
    }

    public function getParams(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId
        ];
    }

    /**
     * @param array $result
     *
     * @return ChatMember
     */
    public function buildResult($result)
    {
        return new ChatMember($result);
    }
}
