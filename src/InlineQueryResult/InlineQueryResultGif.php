<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait, InputMessageContentTrait, JsonAttributesBuilderTrait, ReplyMarkupTrait, TitleTrait
};
use Steelbot\TelegramBotApi\Type\InputMessageContentInterface;

class InlineQueryResultGif extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'gif';

    /**
     * A valid URL for the GIF file. File size must not exceed 1MB.
     *
     * @var string
     */
    protected $gifUrl;

    /**
     * Width of the GIF.
     *
     * @var int|null
     */
    protected $gifWidth;

    /**
     * Height of the GIF.
     *
     * @var int|null
     */
    protected $gifHeight;

    /**
     * @var string
     */
    protected $thumbUrl;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $gifUrl, string $thumbUrl)
    {
        parent::__construct($id);
        $this->gifUrl = $gifUrl;
        $this->thumbUrl = $thumbUrl;
    }

    /**
     * @return string
     */
    public function getGifUrl(): string
    {
        return $this->gifUrl;
    }

    /**
     * @param string $gifUrl
     *
     * @return InlineQueryResultGif
     */
    public function setGifUrl(string $gifUrl): InlineQueryResultGif
    {
        $this->gifUrl = $gifUrl;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGifWidth(): ?int
    {
        return $this->gifWidth;
    }

    /**
     * @param int|null $gifWidth
     *
     * @return InlineQueryResultGif
     */
    public function setGifWidth(?int $gifWidth = null)
    {
        $this->gifWidth = $gifWidth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGifHeight(): ?int
    {
        return $this->gifHeight;
    }

    /**
     * @param int|null $gifHeight
     *
     * @return InlineQueryResultGif
     */
    public function setGifHeight(?int $gifHeight = null): self
    {
        $this->gifHeight = $gifHeight;

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
     * @return InlineQueryResultGif
     */
    public function setThumbUrl(string $thumbUrl): InlineQueryResultGif
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'gif_url' => $this->gifUrl,
            'thumb_url' => $this->thumbUrl
        ]);

        $attributes = $this->buildJsonAttributes([
            'gif_width' => $this->gifWidth,
            'gif_height' => $this->gifHeight,
            'title' => $this->title,
            'caption' => $this->caption,
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
