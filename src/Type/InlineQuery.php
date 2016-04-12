<?php

namespace Steelbot\TelegramBotApi\Type;

class InlineQuery
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var User
     */
    public $from;

    /**
     * @var Location
     */
    public $location;

    /**
     * @var string
     */
    public $query;

    /**
     * @var string
     */
    public $offset;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->from  = new User($data['from']);
        $this->location = $data['location'] ? new Location($data['location']) : null;
        $this->query = $data['query'];
        $this->offset = $data['offset'];
    }
}
