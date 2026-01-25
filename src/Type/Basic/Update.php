<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type\Basic;

use Steelbot\TelegramBotApi\Type\CallbackQuery;
use Steelbot\TelegramBotApi\Type\ChosenInlineResult;
use Steelbot\TelegramBotApi\Type\InlineQuery;
use Steelbot\TelegramBotApi\Type\Message;
use LogicException;

class Update
{
    public int $updateId;

    public ?Message $message;

    public ?InlineQuery $inlineQuery;

    public ?ChosenInlineResult $chosenInlineResult;

    public ?CallbackQuery $callbackQuery;

    protected array $rawData;

    public function __construct(array $data)
    {
        $this->updateId = $data['update_id'];
        $this->message = isset($data['message']) ?
            new Message($data['message']) : null;
        $this->inlineQuery = isset($data['inline_query']) ?
            new InlineQuery($data['inline_query']) : null;
        $this->chosenInlineResult = isset($data['chosen_inline_result']) ?
            new ChosenInlineResult($data['chosen_inline_result']) : null;
        $this->callbackQuery = isset($data['callback_query']) ?
            new CallbackQuery($data['callback_query']) : null;

        $this->rawData = $data;
    }

    public function getType(): UpdateType
    {
        return match (true) {
            $this->message !== null => UpdateType::Message,
            $this->inlineQuery !== null => UpdateType::InlineQuery,
            $this->chosenInlineResult !== null => UpdateType::ChosenInlineResult,
            $this->callbackQuery !== null => UpdateType::CallbackQuery,
            default => throw new LogicException("Unknown update type"),
        };
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }
}
