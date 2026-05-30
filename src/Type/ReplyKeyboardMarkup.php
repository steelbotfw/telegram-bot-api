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

    public function __construct(
        /**
         * @var list<list<string|KeyboardButton>> $keyboard
         */
        private array $keyboard,
        private ?bool $isPersistent = null,
        private ?bool $resizeKeyboard = null,
        private ?bool $oneTimeKeyboard = null,
        private ?string $inputFieldPlaceholder = null
    ) {
    }

    public function getKeyboard(): array
    {
        return $this->keyboard;
    }

    public function setKeyboard(array $keyboard): static
    {
        $this->keyboard = $keyboard;

        return $this;
    }

    /**
     * @param array<KeyboardButton|string> $row
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
            'keyboard' => array_values(
                array_map(
                    static fn (array $row): array => array_map(
                        static fn (KeyboardButton|string $kb) => is_string($kb) ? $kb : $kb->jsonSerialize(),
                        $row
                    ),
                    $this->keyboard
                )
            )
        ];

        if ($this->selective !== null) {
            $result['selective'] = $this->selective;
        }

        return $result;
    }
}
