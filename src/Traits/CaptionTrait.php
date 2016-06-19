<?php

namespace Steelbot\TelegramBotApi\Traits;

trait CaptionTrait
{
    /**
     * @var string|null
     */
    protected $caption = null;

    /**
     * @return null|string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param null|string $caption
     *
     * @return $this
     */
    public function setCaption(string $caption = null): self
    {
        $this->caption = $caption;

        return $this;
    }
}
