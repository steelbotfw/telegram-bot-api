<?php

namespace Steelbot\TelegramBotApi\Method;

class GetChatMembersCount extends AbstractMethod
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
