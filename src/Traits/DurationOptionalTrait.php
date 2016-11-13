<?php

namespace Steelbot\TelegramBotApi\Traits;

trait DurationOptionalTrait
{
    /**
     * @var int|null
     */
    protected $duration;

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int|null $duration
     *
     * @return $this
     */
    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
