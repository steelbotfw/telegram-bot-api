<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * ResponseParameters
 */
class ResponseParameters
{
    /**
     * @var int|null
     */
    public $migrateToChatId;

    /**
     * @var int|null
     */
    public $retryAfter;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->migrateToChatId = $data['migrate_to_chat_id'] ?? null;
        $this->retryAfter = $data['retry_after'] ?? null;
    }
}
