<?php

namespace Steelbot\TelegramBotApi\Traits;

trait DisableWebPagePreviewTrait
{
    /**
     * @var bool
     */
    protected $disableWebPagePreview = null;

    /**
     * @return bool|null
     */
    public function getDisableWebPagePreview()
    {
        return $this->disableWebPagePreview;
    }

    /**
     * @param boolean $disableWebPagePreview
     *
     * @return $this
     */
    public function setDisableWebPagePreview(bool $disableWebPagePreview = null): self
    {
        $this->disableWebPagePreview = $disableWebPagePreview;

        return $this;
    }
}
