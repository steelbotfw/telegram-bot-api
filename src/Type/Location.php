<?php

namespace Steelbot\TelegramBotApi\Type;

class Location
{
    /**
     * @var float
     */
    public $longitude;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->longitude = $data['longitude'];
        $this->latitude = $data['latitude'];
    }
}
