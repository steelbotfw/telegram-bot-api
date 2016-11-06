<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ThumbUrlRequiredTrait
{
    /**
     * @var string
     */
    protected $thumbUrl;

    /**
     * @return string
     */
    public function getThumbUrl(): string
    {
        return $this->thumbUrl;
    }

    /**
     * @param string $thumbUrl
     *
     * @return $this
     */
    public function setThumbUrl(string $thumbUrl): self
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }
}
