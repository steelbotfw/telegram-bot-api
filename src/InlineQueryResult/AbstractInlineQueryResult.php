<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\InputMessageContentTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

abstract class AbstractInlineQueryResult implements \JsonSerializable
{
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? uniqid('steelbot', true);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function jsonSerialize()
    {
        $result = [
            'type' => $this->type,
            'id' => $this->id
        ];

        if ($this->inputMessageContent !== null) {
            $result['input_message_content'] = $this->inputMessageContent;
        }

        if ($this->replyMarkup !== null) {
            $result['reply_markup'] = $this->replyMarkup;
        }

        return $result;
    }
}
