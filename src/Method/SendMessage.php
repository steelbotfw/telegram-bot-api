<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\Message;

class SendMessage extends AbstractMethod
{
    protected $chatId;
    protected $text;
    protected $parseMode = null;
    protected $disableWebPagePreview = false;
    protected $disableNotification = false;
    protected $replyToMessageId = null;
    protected $replyMarkup = null;

    public function __construct($chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
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
     * @return SendMessage
     */
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @return null
     */
    public function getReplyMarkup()
    {
        return $this->replyMarkup;
    }

    /**
     * @param string|null $replyMarkup
     *
     * @return SendMessage
     */
    public function setReplyMarkup(string $replyMarkup = null)
    {
        $this->replyMarkup = $replyMarkup;

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
     * @return SendMessage
     */
    public function setReplyToMessageId(int $replyToMessageId = null)
    {
        $this->replyToMessageId = $replyToMessageId;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisableNotification()
    {
        return $this->disableNotification;
    }

    /**
     * @param boolean $disableNotification
     *
     * @return SendMessage
     */
    public function setDisableNotification(bool $disableNotification = false)
    {
        $this->disableNotification = $disableNotification;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisableWebPagePreview()
    {
        return $this->disableWebPagePreview;
    }

    /**
     * @param boolean $disableWebPagePreview
     *
     * @return SendMessage
     */
    public function setDisableWebPagePreview(bool $disableWebPagePreview = false)
    {
        $this->disableWebPagePreview = $disableWebPagePreview;

        return $this;
    }

    /**
     * @return null
     */
    public function getParseMode()
    {
        return $this->parseMode;
    }

    /**
     * @param string|null $parseMode
     *
     * @return SendMessage
     */
    public function setParseMode(string $parseMode = null)
    {
        $this->parseMode = $parseMode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     *
     * @return SendMessage
     */
    public function setText($text)
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
        return 'sendMessage';
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
            'chat_id' => $this->chatId
        ];

        if ($this->parseMode) {
            $params['parse_mode'] = $this->parseMode;
        }

        if ($this->disableWebPagePreview) {
            $params['disable_web_page_preview'] = $this->disableWebPagePreview;
        }

        if ($this->disableNotification) {
            $params['disable_notification'] = $this->disableNotification;
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
    public function buildResult(array $result)
    {
        return new Message($result);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $data = [
            'text' => $this->text
        ];

        if ($this->replyMarkup) {
            $data['reply_markup'] = $this->replyMarkup;
        }

        return $data;
    }
}
