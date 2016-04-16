<?php

namespace Steelbot\TelegramBotApi\Type;
use Steelbot\TelegramBotApi\Traits\SelectiveTrait;

/**
 * ReplyKeyboardHide
 */
class ReplyKeyboardHide implements ReplyMarkupInterface
{
    use SelectiveTrait;

    protected $hideKeyboard = true;

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        $result = [
            'hide_keyboard' => $this->hideKeyboard
        ];

        if ($this->selective !== null) {
            $result['selective'] = $this->selective;
        }

        return $result;
    }
}
