<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait, DescriptionTrait, TitleTrait
};
use Steelbot\TelegramBotApi\Traits\InputMessageContentTrait;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ThumbUrlRequiredTrait;

class InlineQueryResultMpeg4Gif extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use ThumbUrlRequiredTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'mpeg4_gif';

    /**
     * @var string
     */
    protected $mpeg4url;

    /**
     * @var int|null
     */
    protected $mpeg4width;

    /**
     * @var int|null
     */
    protected $mpeg4height;

    /**
     * @param $id
     */
    public function __construct($id, string $mpeg4url, string $thumbUrl)
    {
        parent::__construct($id);
        $this->mpeg4url = $mpeg4url;
        $this->thumbUrl = $thumbUrl;
    }

    /**
     * @return string
     */
    public function getMpeg4url(): string
    {
        return $this->mpeg4url;
    }

    /**
     * @param string $mpeg4url
     *
     * @return InlineQueryResultMpeg4Gif
     */
    public function setMpeg4url(string $mpeg4url)
    {
        $this->mpeg4url = $mpeg4url;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMpeg4width(): ?int
    {
        return $this->mpeg4width;
    }

    /**
     * @param int|null $mpeg4width
     *
     * @return InlineQueryResultMpeg4Gif
     */
    public function setMpeg4width(?int $mpeg4width)
    {
        $this->mpeg4width = $mpeg4width;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMpeg4height(): ?int
    {
        return $this->mpeg4height;
    }

    /**
     * @param int|null $mpeg4height
     *
     * @return InlineQueryResultMpeg4Gif
     */
    public function setMpeg4height(?int $mpeg4height): self
    {
        $this->mpeg4height = $mpeg4height;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'mpeg4_url' => $this->mpeg4url,
            'thumb_url' => $this->thumbUrl
        ]);

        $attributes = $this->buildJsonAttributes([
            'mpeg4_width'  => $this->mpeg4width,
            'mpeg4_height' => $this->mpeg4height,
            'title' => $this->title,
            'caption' => $this->caption,
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
