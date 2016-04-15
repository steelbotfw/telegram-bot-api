<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * ReplyKeyboardHide
 */
class ReplyKeyboardHide implements ReplyMarkupInterface
{
    protected $hideKeyboard = true;

    /**
     * @var bool|null
     */
    protected $selective = null;

    public function __construct()
    {

    }

    /**
     * @return null
     */
    public function getSelective(): bool
    {
        return $this->selective;
    }

    /**
     * @param null $selective
     *
     * @return ReplyKeyboardHide
     */
    public function setSelective(bool $selective = null)
    {
        $this->selective = $selective;

        return $this;
    }

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
