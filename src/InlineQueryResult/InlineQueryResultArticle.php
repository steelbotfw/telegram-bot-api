<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\InlineQueryResult\Traits\DescriptionTrait;
use Steelbot\TelegramBotApi\InlineQueryResult\Traits\DisableWebPagePreviewTrait;
use Steelbot\TelegramBotApi\InlineQueryResult\Traits\ParseModeTrait;
use Steelbot\TelegramBotApi\InlineQueryResult\Traits\HideUrlTrait;

class InlineQueryResultArticle implements \JsonSerializable
{
    use ParseModeTrait;
    use DisableWebPagePreviewTrait;
    use HideUrlTrait;
    use DescriptionTrait;

    /**
     * @var string
     */
    protected $type = 'article';

    /**
     * @var
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $messageText;

    /**
     * @var string|null
     */
    protected $url = null;

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
    public function __construct($id = null, string $title, string $messageText)
    {
        $this->id = $id ? $id : uniqid('steelbot', true);
        $this->title = $title;
        $this->messageText = $messageText;
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
        $result = [
            'type' => $this->type,
            'id' => $this->id,
            'title' => $this->title,
            'message_text' => $this->messageText
        ];

        if ($this->parseMode !== null) {
            $result['parse_mode'] = $this->parseMode;
        }

        if ($this->disableWebPagePreview !== null) {
            $result['disable_web_page_preview'] = (int)$this->disableWebPagePreview;
        }

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
