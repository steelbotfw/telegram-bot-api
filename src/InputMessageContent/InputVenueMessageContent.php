<?php

namespace Steelbot\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InputVenueMessageContent implements InputMessageContentInterface
{
    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $foursquareId;

    public function __construct(float $latitude, float $longitude, string $title, string $address)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->title = $title;
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return InputLocationMessageContent
     */
    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return InputLocationMessageContent
     */
    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return InputVenueMessageContent
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $address
     *
     * @return InputVenueMessageContent
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string|null $foursquareId
     *
     * @return InputVenueMessageContent
     */
    public function setFoursquareId(?string $foursquareId = null): self
    {
        $this->foursquareId = $foursquareId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFoursquareId(): ?string
    {
        return $this->foursquareId;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'title' => $this->title,
            'address' => $this->address
        ];

        if ($this->foursquareId !== null) {
            $result['foursquare_id'] = $this->foursquareId;
        }

        return $result;
    }
}
