<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait,
    DescriptionTrait,
    DisableWebPagePreviewTrait,
    InputMessageContentTrait,
    ParseModeTrait,
    HideUrlTrait,
    ReplyMarkupTrait,
    TitleTrait
};

class InlineQueryResultCachedVideo extends AbstractInlineQueryResult
{
    use TitleTrait;
    use DescriptionTrait;
    use CaptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'video';

    /**
     * @var string
     */
    protected $videoFileId;

    /**
     * @param array $data
     */
    public function __construct($id, string $videoFileId)
    {
        parent::__construct($id);
        $this->videoFileId = $videoFileId;
    }

    /**
     * @return string
     */
    public function getVideoFileId(): string
    {
        return $this->videoFileId;
    }

    /**
     * @param string $videoFileId
     *
     * @return InlineQueryResultCachedVideo
     */
    public function setVideoFileId(string $videoFileId)
    {
        $this->videoFileId = $videoFileId;

        return $this;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['video_file_id'] = $this->videoFileId;

        if ($this->title !== null) {
            $result['title'] = $this->title;
        }

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        if ($this->caption !== null) {
            $result['caption'] = $this->caption;
        }

        if ($this->replyMarkup) {
            $result['reply_markup'] = $this->replyMarkup;
        }

        if ($this->inputMessageContent) {
            $result['input_message_content'] = $this->inputMessageContent;
        }

        return $result;
    }
}
