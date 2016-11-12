<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait, DescriptionTrait, TitleTrait
};
use Steelbot\TelegramBotApi\Traits\InputMessageContentTrait;
use Steelbot\TelegramBotApi\Traits\JsonAttributesBuilderTrait;
use Steelbot\TelegramBotApi\Traits\ReplyMarkupTrait;
use Steelbot\TelegramBotApi\Traits\ThumbUrlRequiredTrait;
use Steelbot\TelegramBotApi\Traits\TitleRequiredTrait;

class InlineQueryResultVideo extends AbstractInlineQueryResult
{
    use TitleRequiredTrait;
    use CaptionTrait;
    use ThumbUrlRequiredTrait;
    use DescriptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'video';

    /**
     * @var string
     */
    protected $videoUrl;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var int|null
     */
    protected $videoWidth;

    /**
     * @var int|null
     */
    protected $videoHeight;

    /**
     * @var int|null
     */
    protected $videoDuration;

    /**
     * @param $id
     */
    public function __construct($id, string $videoUrl, string $mimeType, string $thumbUrl, string $title)
    {
        parent::__construct($id);
        $this->videoUrl = $videoUrl;
        $this->mimeType = $mimeType;
        $this->thumbUrl = $thumbUrl;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     *
     * @return self
     */
    public function setVideoUrl(string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return self
     */
    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVideoWidth(): ?int
    {
        return $this->videoWidth;
    }

    /**
     * @param int|null $videoWidth
     *
     * @return self
     */
    public function setVideoWidth(?int $videoWidth): self
    {
        $this->videoWidth = $videoWidth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVideoHeight(): ?int
    {
        return $this->videoHeight;
    }

    /**
     * @param int|null $videoHeight
     *
     * @return self
     */
    public function setVideoHeight(?int $videoHeight): self
    {
        $this->videoHeight = $videoHeight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVideoDuration(): ?int
    {
        return $this->videoDuration;
    }

    /**
     * @param int|null $videoDuration
     *
     * @return self
     */
    public function setVideoDuration(?int $videoDuration): self
    {
        $this->videoDuration = $videoDuration;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'video_url' => $this->videoUrl,
            'mime_type' => $this->mimeType,
            'thumb_url' => $this->thumbUrl,
            'title' => $this->title,
        ]);

        $attributes = $this->buildJsonAttributes([
            'video_width' => $this->videoWidth,
            'video_height' => $this->videoHeight,
            'video_duration' => $this->videoDuration,
            'description' => $this->description,
            'caption' => $this->caption,
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
