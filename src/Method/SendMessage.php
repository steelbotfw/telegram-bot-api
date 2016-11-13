<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\DisableWebPagePreviewTrait;
use Steelbot\TelegramBotApi\Traits\ParseModeTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;
use Steelbot\TelegramBotApi\Type\Message;

class SendMessage extends AbstractMethod implements \JsonSerializable
{
    use ChatIdRequiredTrait;
    use ParseModeTrait;
    use DisableWebPagePreviewTrait;
    use ReplyMarkupTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;

    /**
     * @var string
     */
    protected $text;

    public function __construct($chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
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
            $params['disable_web_page_preview'] = (int)$this->disableWebPagePreview;
        }

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
