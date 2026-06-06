<?php

namespace Steelbot\TelegramBotApi\Traits;

trait TitleTrait
{
    /**
     * @var string|null
     */
    protected $title = null;

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title = null): self
    {
        $this->title = $title;

        return $this;
    }
}
