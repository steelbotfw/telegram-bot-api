<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

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
     * @return InlineQueryResultArticle
     */
    public function setParseMode(string $parseMode = null)
    {
        $this->parseMode = $parseMode;

        return $this;
    }
}
