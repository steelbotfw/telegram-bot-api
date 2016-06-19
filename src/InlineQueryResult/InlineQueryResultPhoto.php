<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait, DescriptionTrait, TitleTrait
};

class InlineQueryResultPhoto extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use DescriptionTrait;

    /**
     * @var string
     */
    protected $type = 'photo';

    /**
     * @var string
     */
    protected $photoUrl;

    /**
     * @var string
     */
    protected $thumbUrl;

    /**
     * @var int|null
     */
    protected $photoWidth;

    /**
     * @var int|null
     */
    protected $photoHeight;

    /**
     * @param array $data
     */
    public function __construct($id, string $photoUrl, string $thumbUrl)
    {
        parent::__construct($id);
        $this->photoUrl = $photoUrl;
        $this->thumbUrl = $thumbUrl;
    }

    /**
     * @return string
     */
    public function getPhotoUrl(): string
    {
        return $this->photoUrl;
    }

    /**
     * @param string $photoUrl
     *
     * @return InlineQueryResultPhoto
     */
    public function setPhotoUrl(string $photoUrl)
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

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
     * @return InlineQueryResultPhoto
     */
    public function setThumbUrl(string $thumbUrl)
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhotoWidth()
    {
        return $this->photoWidth;
    }

    /**
     * @param int|null $photoWidth
     *
     * @return InlineQueryResultPhoto
     */
    public function setPhotoWidth(int $photoWidth = null)
    {
        $this->photoWidth = $photoWidth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhotoHeight()
    {
        return $this->photoHeight;
    }

    /**
     * @param int|null $photoHeight
     *
     * @return InlineQueryResultPhoto
     */
    public function setPhotoHeight(int $photoHeight = null)
    {
        $this->photoHeight = $photoHeight;

        return $this;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = parent::jsonSerialize();

        $result['photo_url'] = $this->photoUrl;
        $result['thumb_url'] = $this->thumbUrl;

        if ($this->photoHeight !== null) {
            $result['photo_height'] = $this->photoHeight;
        }

        if ($this->photoWidth !== null) {
            $result['photo_width'] = $this->photoWidth;
        }

        if ($this->title !== null) {
            $result['title'] = $this->title;
        }

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        if ($this->caption !== null) {
            $result['caption'] = $this->caption;
        }

        return $result;
    }
}
