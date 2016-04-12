<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ReplyMarkupTrait
{
    /**
     * @var string|null
     */
    protected $replyMarkup = null;

    /**
     * @return null
     */
    public function getReplyMarkup()
    {
        return $this->replyMarkup;
    }

    /**
     * @param string|null $replyMarkup
     *
     * @return SendMessage
     */
    public function setReplyMarkup(string $replyMarkup = null)
    {
        $this->replyMarkup = $replyMarkup;

        return $this;
    }
}
