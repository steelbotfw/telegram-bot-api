<?php

namespace Steelbot\TelegramBotApi\Type;
use Steelbot\TelegramBotApi\Traits\SelectiveTrait;

/**
 * ForceReply
 */
class ForceReply implements ReplyMarkupInterface
{
    use SelectiveTrait;

    protected $forceReply = true;

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        $result = [
            'force_reply' => $this->forceReply
        ];

        if ($this->selective !== null) {
            $result['selective'] = $this->selective;
        }

        return $result;
    }
}
