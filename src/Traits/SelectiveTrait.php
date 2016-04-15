<?php

namespace Steelbot\TelegramBotApi\Traits;

trait SelectiveTrait
{
    /**
     * Use this parameter if you want to show the keyboard to specific users only.
     * Targets:
     *  1) users that are @mentioned in the text of the Message object;
     *  2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     *
     * @var bool|null
     */
    protected $selective;

    /**
     * @return null
     */
    public function getSelective(): bool
    {
        return $this->selective;
    }

    /**
     * @param null $selective
     *
     * @return ReplyKeyboardHide
     */
    public function setSelective(bool $selective = null)
    {
        $this->selective = $selective;

        return $this;
    }

}
