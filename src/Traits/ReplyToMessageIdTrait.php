<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ReplyToMessageIdTrait
{
    /**
     * If the message is a reply, ID of the original message.
     *
     * @var null|int
     */
    protected $replyToMessageId;

    /**
     * @return integer|null
     */
    public function getReplyToMessageId()
    {
        return $this->replyToMessageId;
    }

    /**
     * @param null $replyToMessageId
     *
     * @return self
     */
    public function setReplyToMessageId(int $replyToMessageId = null)
    {
        $this->replyToMessageId = $replyToMessageId;

        return $this;
    }
}
