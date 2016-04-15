<?php

namespace Steelbot\TelegramBotApi\Traits;

use Steelbot\TelegramBotApi\Type\ReplyMarkupInterface;

trait ReplyMarkupTrait
{
    /**
     * @var ReplyMarkupInterface|null
     */
    protected $replyMarkup;

    /**
     * @return ReplyMarkupInterface|null
     */
    public function getReplyMarkup()
    {
        return $this->replyMarkup;
    }

    /**
     * @param ReplyMarkupInterface|null $replyMarkup
     *
     * @return $this
     */
    public function setReplyMarkup(ReplyMarkupInterface $replyMarkup = null)
    {
        $this->replyMarkup = $replyMarkup;

        return $this;
    }
}
