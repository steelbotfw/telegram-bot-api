<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * CallbackQuery
 */
class CallbackQuery
{
    /**
     * Unique identifier for this query.
     *
     * @var string
     */
    public $id;

    public $from;

    public $message;

    public $inlineMessageId;

    public $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->from = new User($data['from']);
        $this->message = isset($data['message']) ? new Message($data['message']) : null;
        $this->inlineMessageId = $data['inline_message_id'] ?? null;
        $this->data = $data['data'];
    }
}
