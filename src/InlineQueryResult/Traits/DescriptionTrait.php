<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult\Traits;

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
     * @return InlineQueryResultArticle
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;

        return $this;
    }
}
