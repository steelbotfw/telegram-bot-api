<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * InlineKeyboardMarkup
 */
class InlineKeyboardMarkup implements ReplyMarkupInterface
{
    /**
     * Array of button rows, each represented by an Array of InlineKeyboardButton objects.
     *
     * @var InlineKeyboardButton[][]
     */
    protected $inlineKeyboard;

    /**
     * @param string $text
     */
    public function __construct(array $keyboard)
    {
        $this->inlineKeyboard = $keyboard;
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

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        return [
            'inline_keyboard' => $this->inlineKeyboard
        ];
    }
}
