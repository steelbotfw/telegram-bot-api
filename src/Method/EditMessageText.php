<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\{
    Traits\DisableWebPagePreviewTrait,
    Traits\ReplyMarkupTrait,
    Traits\ParseModeTrait,
    Type\Message
};

class EditMessageText extends AbstractMethod implements \JsonSerializable
{
    use DisableWebPagePreviewTrait;
    use ParseModeTrait;
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
     * @var string
     */
    protected $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

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
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'editMessageText';
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
    function jsonSerialize()
    {
        $data = [
            'text' => $this->text
        ];

        if ($this->replyMarkup) {
            $data['reply_markup'] = $this->replyMarkup;
        }

        if ($this->parseMode !== null) {
            $data['parse_mode'] = $this->parseMode;
        }

        if ($this->disableWebPagePreview !== null) {
            $data['disable_web_page_preview'] = (int)$this->disableWebPagePreview;
        }

        return $data;
    }
}
