<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

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
     * @return InlineQueryResultArticle
     */
    public function setHideUrl(bool $hideUrl = null)
    {
        $this->hideUrl = $hideUrl;

        return $this;
    }
}
