<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

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
     * @return InlineQueryResultArticle
     */
    public function setDisableWebPagePreview(bool $disableWebPagePreview = null)
    {
        $this->disableWebPagePreview = $disableWebPagePreview;

        return $this;
    }
}
