<?php

namespace Steelbot\TelegramBotApi\Type;

class ChosenInlineResult
{
    /**
     * @var string
     */
    public $resultId;

    /**
     * @var User
     */
    public $from;

    /**
     * @var Location
     */
    public $location;

    /**
     * @var string|null
     */
    public $inlineMessageId;

    /**
     * @var string
     */
    public $query;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->resultId = $data['result_id'];
        $this->from  = new User($data['from']);
        $this->location = isset($data['location']) ? new Location($data['location']) : null;
        $this->inlineMessageId = $data['inline_message_id'] ?? null;
        $this->query = $data['query'];
    }
}
