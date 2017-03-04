<?php

namespace Steelbot\TelegramBotApi\Type;
use Steelbot\TelegramBotApi\Traits\SelectiveTrait;

/**
 * ReplyKeyboardRemove
 */
class ReplyKeyboardRemove implements ReplyMarkupInterface
{
    use SelectiveTrait;

    protected $removeKeyboard = true;

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        $result = [
            'remove_keyboard' => $this->removeKeyboard
        ];

        if ($this->selective !== null) {
            $result['selective'] = $this->selective;
        }

        return $result;
    }
}
