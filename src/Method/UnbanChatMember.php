<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;

class UnbanChatMember extends AbstractMethod
{
    use ChatIdRequiredTrait;

    /**
     * @var integer
     */
    protected $userId;

    public function __construct($chatId, int $userId)
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
     * @return UnbanChatMember
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'unbanChatMember';
    }

    /**
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return self::HTTP_POST;
    }

    /**
     * Get parameters for HTTP query.
     *
     * @return mixed
     */
    public function getParams(): array
    {
        $params = [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId
        ];

        return $params;
    }

    /**
     * Build result type from array of data.
     *
     * @param bool $result
     *
     * @return bool
     */
    public function buildResult($result)
    {
        return $result;
    }
}
