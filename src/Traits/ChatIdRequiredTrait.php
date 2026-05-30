<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Traits;

trait ChatIdRequiredTrait
{
    protected string|int $chatId;

    public function getChatId(): int|string
    {
        return $this->chatId;
    }

    public function setChatId(int|string $chatId): static
    {
        $this->chatId = $chatId;

        return $this;
    }
}
