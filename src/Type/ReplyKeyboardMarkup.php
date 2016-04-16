<?php

namespace Steelbot\TelegramBotApi\Type;
use Steelbot\TelegramBotApi\Traits\SelectiveTrait;

/**
 * ReplyKeyboardMarkup
 */
class ReplyKeyboardMarkup implements ReplyMarkupInterface
{
    use SelectiveTrait;

    /**
     * Array of button rows, each represented by an Array of KeyboardButton objects.
     *
     * @var KeyboardButton[][]
     */
    protected $keyboard;

    /**
     * Requests clients to resize the keyboard vertically for optimal fit
     * (e.g., make the keyboard smaller if there are just two rows of buttons).
     * Defaults to false, in which case the custom keyboard is always of the same height
     * as the app's standard keyboard.
     *
     * @var bool|null
     */
    protected $resizeKeyboard;

    /**
     * Requests clients to hide the keyboard as soon as it's been used. The keyboard will still
     * be available, but clients will automatically display the usual letter-keyboard in the
     * chat – the user can press a special button in the input field to see the custom keyboard
     * again. Defaults to false.
     *
     * @var bool|null
     */
    protected $oneTimeKeyboard;

    /**
     * ReplyKeyboardMarkup constructor.
     *
     * @param string[][]|KeyboardButton[][] $keyboard
     */
    public function __construct(array $keyboard)
    {
        $this->keyboard = $keyboard;
    }

    /**
     * @return KeyboardButton[][]
     */
    public function getKeyboard()
    {
        return $this->keyboard;
    }

    /**
     * @param KeyboardButton[][] $keyboard
     *
     * @return ReplyKeyboardMarkup
     */
    public function setKeyboard(array $keyboard)
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    /**
     * @param KeyboardButton[] $row
     *
     * @return ReplyKeyboardMarkup
     */
    public function addKeyboardRow(array $row = []): self
    {
        $this->keyboard[] = $row;

        return $this;
    }

    /**
     * @param string|KeyboardButton $button
     *
     * @return ReplyKeyboardMarkup
     */
    public function addKeyboardButton($button): self
    {
        if (!(is_string($button) || ($button instanceof KeyboardButton))) {
            throw new \DomainException("Button should be a string or a KeyboardButton instance");
        }

        $lastRowIndex = max(count($this->keyboard) - 1, 0);
        $this->keyboard[$lastRowIndex][] = $button;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOneTimeKeyboard()
    {
        return $this->oneTimeKeyboard;
    }

    /**
     * @param bool|null $oneTimeKeyboard
     *
     * @return ReplyKeyboardMarkup
     */
    public function setOneTimeKeyboard(bool $oneTimeKeyboard = null): self
    {
        $this->oneTimeKeyboard = $oneTimeKeyboard;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getResizeKeyboard()
    {
        return $this->resizeKeyboard;
    }

    /**
     * @param bool|null $resizeKeyboard
     *
     * @return ReplyKeyboardMarkup
     */
    public function setResizeKeyboard(bool $resizeKeyboard = null): self
    {
        $this->resizeKeyboard = $resizeKeyboard;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        $result = [
            'keyboard' => $this->keyboard
        ];

        if ($this->selective !== null) {
            $result['selective'] = $this->selective;
        }

        return $result;
    }
}
