<?php

namespace Steelbot\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\Traits\DisableWebPagePreviewTrait;
use Steelbot\TelegramBotApi\Traits\ParseModeTrait;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InputTextMessageContent implements InputMessageContentInterface
{
    use ParseModeTrait;
    use DisableWebPagePreviewTrait;

    /**
     * @var string
     */
    protected $messageText;

    public function __construct(string $messageText)
    {
        $this->messageText = $messageText;
    }

    /**
     * @return string
     */
    public function getMessageText(): string
    {
        return $this->messageText;
    }

    /**
     * @param string $messageText
     *
     * @return InputTextMessageContent
     */
    public function setMessageText(string $messageText): self
    {
        $this->messageText = $messageText;

        return $this;
    }

    public function jsonSerialize()
    {
        $result = [
            'message_text' => $this->messageText
        ];

        if ($this->parseMode !== null) {
            $result['parse_mode'] = $this->parseMode;
        }

        if ($this->disableWebPagePreview !== null) {
            $result['disable_web_page_preview'] = (int)$this->disableWebPagePreview;
        }

        return $result;
    }
}
