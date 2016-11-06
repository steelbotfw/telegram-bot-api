<?php

namespace Steelbot\TelegramBotApi\Traits;

trait ThumbWidthHeightOptionalTrait
{
    /**
     * @var int|null
     */
    protected $thumbWidth;

    /**
     * @var int|null
     */
    protected $thumbHeight;

    /**
     * @return int|null
     */
    public function getThumbWidth(): ?int
    {
        return $this->thumbWidth;
    }

    /**
     * @param int $thumbWidth
     *
     * @return self
     */
    public function setThumbWidth(?int $thumbWidth): self
    {
        $this->thumbWidth = $thumbWidth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getThumbHeight(): ?int
    {
        return $this->thumbHeight;
    }

    /**
     * @param int|null $thumbHeight
     *
     * @return self
     */
    public function setThumbHeight(?int $thumbHeight): self
    {
        $this->thumbHeight = $thumbHeight;

        return $this;
    }

}
