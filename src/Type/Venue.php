<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Venue
 */
class Venue
{
    /**
     * Venue location.
     *
     * @var Location
     */
    public $location;

    /**
     * Name of the venue.
     *
     * @var string
     */
    public $title;

    /**
     * Address of the venue.
     *
     * @var string
     */
    public $address;

    /**
     * Foursquare identifier of the venue.
     *
     * @var string|null
     */
    public $foursquareId;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->location = new Location($data['location']);
        $this->title = $data['title'];
        $this->address = $data['address'];
        $this->foursquareId = $data['foursquare_id'] ?? null;
    }
}
