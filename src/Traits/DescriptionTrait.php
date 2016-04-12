<?php

namespace Steelbot\TelegramBotApi\Traits;

trait DescriptionTrait
{
    /**
     * @var string|null
     */
    protected $description = null;

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return $this
     */
    public function setDescription(string $description = null): self
    {
        $this->description = $description;

        return $this;
    }
}
