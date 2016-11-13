<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;
use Steelbot\TelegramBotApi\Type\Message;

class SendPhoto extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;
    use ReplyMarkupTrait;

    /**
     * @var string
     */
    protected $photo;

    /**
     * @var string|null
     */
    protected $caption;

    public function __construct($chatId, string $photo)
    {
        $this->chatId = $chatId;
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     *
     * @return SendPhoto
     */
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param null|string $caption
     *
     * @return SendPhoto
     */
    public function setCaption(string $caption = null): self
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'sendPhoto';
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
            'photo' => $this->photo,
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

        if ($this->caption) {
            $data['caption'] = $this->caption;
        }

        return $data;
    }
}
