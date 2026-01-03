<?php

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;
use Steelbot\TelegramBotApi\Traits\ChatIdRequiredTrait;
use Steelbot\TelegramBotApi\Traits\DisableNotificationTrait;
use Steelbot\TelegramBotApi\Traits\DisableWebPagePreviewTrait;
use Steelbot\TelegramBotApi\Traits\ParseModeTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ReplyToMessageIdTrait;
use Steelbot\TelegramBotApi\Type\Message;

/**
 * @extends AbstractMethod<Message>
 */
class SendMessage extends AbstractMethod implements JsonSerializable
{
    use ChatIdRequiredTrait;
    use ParseModeTrait;
    use DisableWebPagePreviewTrait;
    use ReplyMarkupTrait;
    use DisableNotificationTrait;
    use ReplyToMessageIdTrait;

    public function __construct(
        $chatId,
        private string $text
    ) {
        $this->chatId = $chatId;
    }

    /**
     * @param mixed $chatId
     */
    public function setChatId($chatId): void
    {
        $this->chatId = $chatId;
    }

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
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

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    /**
     * Get parameters for HTTP query.
     *
     * @return array<string|int>
     */
    public function getParams(): array
    {
        $params = [
            'chat_id' => $this->chatId
        ];

        if ($this->parseMode) {
            $params['parse_mode'] = $this->parseMode->value;
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
    public function buildResult($result): object|array|bool|int
    {
        return new Message($result);
    }

    public function jsonSerialize(): array
    {
        $data = [
            'text' => $this->text
        ];

        if ($this->replyMarkup) {
            $data['reply_markup'] = $this->replyMarkup->jsonSerialize();
        }

        if ($this->parseMode) {
            $data['parse_mode'] = $this->parseMode->value;
        }

        return $data;
    }
}
