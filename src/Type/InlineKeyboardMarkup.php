<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Type;

/**
 * InlineKeyboardMarkup
 */
class InlineKeyboardMarkup implements ReplyMarkupInterface
{
    /**
     * @param list<list<InlineKeyboardButton>|null> $inlineKeyboard
     */
    public function __construct(private array $inlineKeyboard)
    {
    }

    /**
     * @return InlineKeyboardButton[][]
     */
    public function getInlineKeyboard(): array
    {
        return $this->inlineKeyboard;
    }

    /**
     * @param InlineKeyboardButton[][] $inlineKeyboard
     *
     * @return InlineKeyboardMarkup
     */
    public function setInlineKeyboard(array $inlineKeyboard)
    {
        $this->inlineKeyboard = $inlineKeyboard;

        return $this;
    }

    public function addKeyboardRow(array $row = []): self
    {
        $this->inlineKeyboard[] = $row;

        return $this;
    }

    public function addKeyboardButton(InlineKeyboardButton $button): self
    {
        $lastRowIndex = max(count($this->inlineKeyboard) - 1, 0);
        $this->inlineKeyboard[$lastRowIndex][] = $button;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'inline_keyboard' => array_filter($this->inlineKeyboard, static fn (?array $row) => $row !== null)
        ];
    }
}
