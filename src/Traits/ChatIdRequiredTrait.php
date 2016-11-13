<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ChatIdRequiredTrait
{
    /**
     * @var string|int
     */
    protected $chatId;

    /**
     * @return int|string
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @param int|string $chatId
     *
     * @return $this
     */
    public function setChatId($chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }
}
