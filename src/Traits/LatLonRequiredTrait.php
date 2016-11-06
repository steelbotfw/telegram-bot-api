<?php

namespace Steelbot\TelegramBotApi\Traits;

trait LatLonRequiredTrait
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
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return self
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
     * @return self
     */
    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
