<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;
use Steelbot\TelegramBotApi\Type\Message;

class SendSticker extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use ReplyMarkupTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;

    /**
     * @var string
     */
    protected $sticker;

    public function __construct($chatId, string $sticker)
    {
        $this->chatId = $chatId;
        $this->sticker = $sticker;
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
