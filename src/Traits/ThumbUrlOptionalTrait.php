<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ThumbUrlOptionalTrait
{
    /**
     * @var string|null
     */
    protected $thumbUrl = null;

    /**
     * @return null|string
     */
    public function getThumbUrl(): ?string
    {
        return $this->thumbUrl;
    }

    /**
     * @param null|string $thumbUrl
     *
     * @return $this
     */
    public function setThumbUrl(?string $thumbUrl): self
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }
}
