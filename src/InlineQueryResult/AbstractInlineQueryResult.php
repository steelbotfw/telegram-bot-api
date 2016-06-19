<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

abstract class AbstractInlineQueryResult implements \JsonSerializable
{
    use ReplyMarkupTrait;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var InputMessageContentInterface|null
     */
    protected $inputMessageContent;

    public function __construct(string $id = null, InputMessageContentInterface $inputMessageContent = null)
    {
        $this->id = $id ?? uniqid('steelbot', true);
        $this->inputMessageContent = $inputMessageContent;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param InputMessageContentInterface|null $inputMessageContent
     */
    public function setInputMessageContent(InputMessageContentInterface $inputMessageContent = null)
    {
        $this->inputMessageContent = $inputMessageContent;
    }

    /**
     * @return InputMessageContentInterface
     */
    public function getInputMessageContent(): InputMessageContentInterface
    {
        return $this->inputMessageContent;
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
