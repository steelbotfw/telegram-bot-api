<?php

namespace Steelbot\TelegramBotApi\Traits;

use Steelbot\TelegramBotApi\Enum\ParseMode;

trait ParseModeTrait
{
    protected ?ParseMode $parseMode;

    public function getParseMode(): ?ParseMode
    {
        return $this->parseMode;
    }

    public function setParseMode(?ParseMode $parseMode = null): static
    {
        $this->parseMode = $parseMode;

        return $this;
    }
}
