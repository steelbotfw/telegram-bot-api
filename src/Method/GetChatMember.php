<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Type\ChatMember;

/**
 * @extends AbstractMethod<ChatMember>
 */
class GetChatMember extends AbstractMethod
{
    use ChatIdRequiredTrait;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @param int|string $chatId
     */
    public function __construct($chatId, $userId)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
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

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
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
    public function buildResult($result): object|array|bool|int
    {
        return new ChatMember($result);
    }
}
