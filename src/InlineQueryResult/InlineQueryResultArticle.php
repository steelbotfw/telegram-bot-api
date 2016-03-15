<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

class InlineQueryResultArticle implements \JsonSerializable
{
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

    public $parseMode;

    public $disableWebPagePreview;

    public $url;

    public $hideUrl;

    public $description;

    /**
     * @var string
     */
    protected $thumbUrl;

    /**
     * @var int
     */
    protected $thumbWidth;

    /**
     * @var int
     */
    protected $thumbHeight;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $title, string $messageText, array $data = [])
    {
        $this->id = $id ? $id : uniqid('steelbot', true);
        $this->title = $title;
        $this->messageText = $messageText;

        $this->parseMode = $data['parse_mode'] ?? null;
        $this->disableWebPagePreview = $data['disable_web_page_preview'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->hideUrl = $data['hide_url'] ?? null;
        $this->description = $data['description'] ?? null;
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

        if ($this->parseMode) {
            $result['parse_mode'] = $this->parseMode;
        }

        if ($this->disableWebPagePreview) {
            $result['disable_web_page_preview'] = (int)$this->disableWebPagePreview;
        }

        if ($this->url) {
            $result['url'] = $this->url;
        }

        if ($this->hideUrl) {
            $result['hide_url'] = (int)$this->hideUrl;
        }

        if ($this->description) {
            $result['description'] = $this->description;
        }

        if ($this->thumbUrl) {
            $result['thumb_url'] = $this->thumbUrl;
        }

        if ($this->thumbWidth) {
            $result['thumb_width'] = $this->thumbWidth;
        }

        if ($this->thumbHeight) {
            $result['thumb_height'] = $this->thumbHeight;
        }

        return $result;
    }
}
