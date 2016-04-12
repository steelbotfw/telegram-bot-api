<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ParseModeTrait
{
    /**
     * @var string|null
     */
    protected $parseMode;

    /**
     * @return null|string
     */
    public function getParseMode()
    {
        return $this->parseMode;
    }

    /**
     * @param null|string $parseMode
     *
     * @return $this
     */
    public function setParseMode(string $parseMode = null): self
    {
        $this->parseMode = $parseMode;

        return $this;
    }
}
