<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Traits\ChatIdRequiredTrait, Traits\DisableNotificationTrait, Traits\ReplyMarkupTrait, Traits\ReplyToMessageIdTrait, Type\Message
};

class SendDocument extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;
    use ReplyMarkupTrait;

    /**
     * @var string
     */
    protected $document;

    /**
     * @var string|null
     */
    protected $caption;

    public function __construct($chatId, string $document)
    {
        $this->chatId = $chatId;
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @param string $document  document ID
     *
     * @return $this
     */
    public function setDocument(string $document): self
    {
        $this->document = $document;

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
     * @return $this
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
        return 'sendDocument';
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
            'document' => $this->document,
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
