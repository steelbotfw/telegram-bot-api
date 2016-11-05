<?php

namespace Steelbot\TelegramBotApi\InputMessageContent;

use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InputLocationMessageContent implements InputMessageContentInterface
{
    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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

    public function jsonSerialize()
    {
        $result = [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];

        return $result;
    }
}
