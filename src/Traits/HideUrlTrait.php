<?php

namespace Steelbot\TelegramBotApi\Traits;

trait HideUrlTrait
{
    /**
     * @var bool|null
     */
    protected $hideUrl;

    /**
     * @return bool|null
     */
    public function getHideUrl()
    {
        return $this->hideUrl;
    }

    /**
     * @param bool|null $hideUrl
     *
     * @return $this
     */
    public function setHideUrl(bool $hideUrl = null): self
    {
        $this->hideUrl = $hideUrl;

        return $this;
    }
}
