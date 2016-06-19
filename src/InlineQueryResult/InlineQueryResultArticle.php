<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    DescriptionTrait, HideUrlTrait, ReplyMarkupTrait, TitleTrait
};
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InlineQueryResultArticle extends AbstractInlineQueryResult
{
    use TitleTrait;
    use ReplyMarkupTrait;
    use DescriptionTrait;

    /**
     * @var string
     */
    protected $type = 'article';

    /**
     * @var string|null
     */
    protected $url = null;

    /**
     * @var bool|null
     */
    protected $hideUrl;

    /**
     * @var string|null
     */
    protected $thumbUrl = null;

    /**
     * @var int|null
     */
    protected $thumbWidth = null;

    /**
     * @var int|null
     */
    protected $thumbHeight = null;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $title, InputMessageContentInterface $inputMessageContent)
    {
        parent::__construct($id);
        $this->setInputMessageContent($inputMessageContent);
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     *
     * @return InlineQueryResultArticle
     */
    public function setUrl(string $url = null)
    {
        $this->url = $url;

        return $this;
    }

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
     * @return self
     */
    public function setHideUrl(bool $hideUrl = null)
    {
        $this->hideUrl = $hideUrl;

        return $this;
    }

    /**
     * @return null
     */
    public function getThumbUrl()
    {
        return $this->thumbUrl;
    }

    /**
     * @param string $thumbUrl
     *
     * @return InlineQueryResultArticle
     */
    public function setThumbUrl(string $thumbUrl = null)
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    /**
     * @return null
     */
    public function getThumbWidth()
    {
        return $this->thumbWidth;
    }

    /**
     * @param int $thumbWidth
     *
     * @return InlineQueryResultArticle
     */
    public function setThumbWidth(int $thumbWidth = null)
    {
        $this->thumbWidth = $thumbWidth;

        return $this;
    }

    /**
     * @return null
     */
    public function getThumbHeight()
    {
        return $this->thumbHeight;
    }

    /**
     * @param int $thumbHeight
     *
     * @return InlineQueryResultArticle
     */
    public function setThumbHeight(int $thumbHeight = null)
    {
        $this->thumbHeight = $thumbHeight;

        return $this;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['title'] = $this->title;

        if ($this->url !== null) {
            $result['url'] = $this->url;
        }

        if ($this->hideUrl !== null) {
            $result['hide_url'] = (int)$this->hideUrl;
        }

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        if ($this->thumbUrl !== null) {
            $result['thumb_url'] = $this->thumbUrl;
        }

        if ($this->thumbWidth !== null) {
            $result['thumb_width'] = $this->thumbWidth;
        }

        if ($this->thumbHeight !== null) {
            $result['thumb_height'] = $this->thumbHeight;
        }

        return $result;
    }
}
