<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    DescriptionTrait,
    HideUrlTrait,
    JsonAttributesBuilderTrait,
    ReplyMarkupTrait,
    TitleTrait
};
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InlineQueryResultArticle extends AbstractInlineQueryResult
{
    use TitleTrait;
    use HideUrlTrait;
    use ReplyMarkupTrait;
    use DescriptionTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'article';

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
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['title'] = $this->title;

        $attributes = $this->buildJsonAttributes([
            'url' => $this->url,
            'hide_url' => $this->hideUrl,
            'description' => $this->description,
            'thumb_url' => $this->thumbUrl,
            'thumb_width' => $this->thumbWidth,
            'thumb_height' => $this->thumbHeight
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
