<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Type\Chat;

class GetChat extends AbstractMethod
{
    use ChatIdRequiredTrait;

    /**
     * GetChat constructor.
     *
     * @param $chatId
     */
    public function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function getMethodName(): string
    {
        return 'getChat';
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
     * @return Chat
     */
    public function buildResult($result): Chat
    {
        return new Chat($result);
    }
}
