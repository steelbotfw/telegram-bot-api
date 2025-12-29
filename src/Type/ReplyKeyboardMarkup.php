<?php

declare(strict_types=1);

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
    protected array $keyboard;

    protected ?bool $isPersistent;

    /**
     * Requests clients to resize the keyboard vertically for optimal fit
     * (e.g., make the keyboard smaller if there are just two rows of buttons).
     * Defaults to false, in which case the custom keyboard is always of the same height
     * as the app's standard keyboard.
     *
     * @var bool|null
     */
    protected ?bool $resizeKeyboard;

    /**
     * Requests clients to hide the keyboard as soon as it's been used. The keyboard will still
     * be available, but clients will automatically display the usual letter-keyboard in the
     * chat – the user can press a special button in the input field to see the custom keyboard
     * again. Defaults to false.
     *
     * @var bool|null
     */
    protected ?bool $oneTimeKeyboard;

    protected ?string $inputFieldPlaceholder;

    /**
     * @param string[][]|KeyboardButton[][] $keyboard
     */
    public function __construct(array $keyboard)
    {
        $this->keyboard = $keyboard;
    }

    /**
     * @return KeyboardButton[][]
     */
    public function getKeyboard(): array
    {
        return $this->keyboard;
    }

    /**
     * @param KeyboardButton[][] $keyboard
     */
    public function setKeyboard(array $keyboard): static
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    /**
     * @param KeyboardButton[] $row
     */
    public function addKeyboardRow(array $row = []): static
    {
        $this->keyboard[] = $row;

        return $this;
    }

    public function addKeyboardButton(string|KeyboardButton $button): static
    {
        $lastRowIndex = max(count($this->keyboard) - 1, 0);
        $this->keyboard[$lastRowIndex][] = $button;

        return $this;
    }

    public function getOneTimeKeyboard(): ?bool
    {
        return $this->oneTimeKeyboard;
    }

    public function setOneTimeKeyboard(?bool $oneTimeKeyboard): static
    {
        $this->oneTimeKeyboard = $oneTimeKeyboard;

        return $this;
    }

    public function getResizeKeyboard(): ?bool
    {
        return $this->resizeKeyboard;
    }

    public function setResizeKeyboard(?bool $resizeKeyboard): static
    {
        $this->resizeKeyboard = $resizeKeyboard;

        return $this;
    }

    public function getIsPersistent(): ?bool
    {
        return $this->isPersistent;
    }

    public function setIsPersistent(?bool $isPersistent): ReplyKeyboardMarkup
    {
        $this->isPersistent = $isPersistent;

        return $this;
    }

    public function getInputFieldPlaceholder(): ?string
    {
        return $this->inputFieldPlaceholder;
    }

    public function setInputFieldPlaceholder(?string $inputFieldPlaceholder): ReplyKeyboardMarkup
    {
        $this->inputFieldPlaceholder = $inputFieldPlaceholder;

        return $this;
    }

    public function jsonSerialize(): array
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
