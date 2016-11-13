<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Type\Message;

class ForwardMessage extends AbstractMethod
{
    use ChatIdRequiredTrait;
    use DisableNotificationTrait;

    protected $fromChatId;

    /**
     * @var int
     */
    protected $messageId;

    public function __construct($chatId, $fromChatId, int $messageId)
    {
        $this->chatId = $chatId;
        $this->fromChatId = $fromChatId;
        $this->messageId = $messageId;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     *
     * @return ForwardMessage
     */
    public function setMessageId(int $messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return int
     */
    public function getFromChatId()
    {
        return $this->fromChatId;
    }

    /**
     * @param int $fromChatId
     *
     * @return ForwardMessage
     */
    public function setFromChatId($fromChatId)
    {
        $this->fromChatId = $fromChatId;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'forwardMessage';
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
            'from_chat_id' => $this->fromChatId,
            'message_id' => $this->messageId
        ];

        if ($this->disableNotification) {
            $params['disable_notification'] = (int)$this->disableNotification;
        }

        return $params;
    }

    /**
     * Build result type from array of data.
     *
     * @param array $result
     *
     * @return object
     */
    public function buildResult($result)
    {
        return new Message($result);
    }
}
