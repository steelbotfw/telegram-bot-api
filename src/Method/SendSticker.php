<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Type\Message;

class SendSticker extends AbstractMethod implements \JsonSerializable
{
    use ReplyMarkupTrait;
    use DisableNotificationTrait;

    /**
     * @var string|integer
     */
    protected $chatId;

    /**
     * @var string
     */
    protected $sticker;

    /**
     * @var int|null
     */
    protected $replyToMessageId;

    public function __construct($chatId, string $sticker)
    {
        $this->chatId = $chatId;
        $this->sticker = $sticker;
    }

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @param string|int $chatId
     *
     * @return self
     */
    public function setChatId($chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @return string
     */
    public function getSticker(): string
    {
        return $this->sticker;
    }

    /**
     * @param string $sticker
     *
     * @return SendSticker
     */
    public function setSticker(string $sticker)
    {
        $this->sticker = $sticker;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getReplyToMessageId()
    {
        return $this->replyToMessageId;
    }

    /**
     * @param null $replyToMessageId
     *
     * @return $this
     */
    public function setReplyToMessageId(int $replyToMessageId = null): self
    {
        $this->replyToMessageId = $replyToMessageId;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendSticker';
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
            'sticker' => $this->sticker,
        ];

        if ($this->disableNotification !== null) {
            $params['disable_notification'] = (int)$this->disableNotification;
        }

        if ($this->replyToMessageId) {
            $params['reply_to_message_id'] = $this->replyToMessageId;
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

    /**
     *
     */
    function jsonSerialize()
    {
        $data = [];

        if ($this->replyMarkup) {
            $data['reply_markup'] = $this->replyMarkup;
        }

        return $data;
    }
}
