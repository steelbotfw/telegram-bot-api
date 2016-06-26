<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Traits\ReplyMarkupTrait,
    Type\Message
};

class EditMessageCaption extends AbstractMethod implements \JsonSerializable
{
    use ReplyMarkupTrait;

    /**
     * @var string|integer|null
     */
    protected $chatId;

    /**
     * @var int|null
     */
    protected $messageId;

    /**
     * @var int|null
     */
    protected $inlineMessageId;

    /**
     * @var string|null
     */
    protected $caption;

    /**
     * @return string|int|null
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @param string|int|null $chatId
     *
     * @return self
     */
    public function setChatId($chatId = null): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param int|null $messageId
     *
     * @return $this
     */
    public function setMessageId(int $messageId = null): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInlineMessageId()
    {
        return $this->inlineMessageId;
    }

    /**
     * @param int|null $inlineMessageId
     *
     * @return self
     */
    public function setInlineMessageId(int $inlineMessageId = null): self
    {
        $this->inlineMessageId = $inlineMessageId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string|null $caption
     *
     * @return self
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
        return 'editMessageCaption';
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
        $params = [];

        if ($this->chatId !== null) {
            $params['chat_id'] = $this->chatId;
        }

        if ($this->messageId) {
            $params['message_id'] = $this->messageId;
        }

        if ($this->inlineMessageId !== null) {
            $params['inline_message_id'] = $this->inlineMessageId;
        }

        return $params;
    }

    /**
     * Build result type from data.
     *
     * @param array|bool $result
     *
     * @return Message|bool
     */
    public function buildResult($result)
    {
        if ($result === true) {
            return true;
        } else {
            return new Message($result);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'caption' => $this->caption
        ];

        if ($this->replyMarkup) {
            $data['reply_markup'] = $this->replyMarkup;
        }

        return $data;
    }
}
