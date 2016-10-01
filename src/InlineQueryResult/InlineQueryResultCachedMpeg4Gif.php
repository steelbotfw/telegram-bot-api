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
    ReplyToMessageIdTrait,
    TitleTrait
};

class InlineQueryResultCachedMpeg4Gif extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use ReplyToMessageIdTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'mpeg4_gif';

    /**
     * @var string
     */
    protected $mpeg4FileId;

    public function __construct($id, string $mpeg4FileId)
    {
        parent::__construct($id);
        $this->mpeg4FileId = $mpeg4FileId;
    }

    /**
     * @return string
     */
    public function getMpeg4FileId(): string
    {
        return $this->mpeg4FileId;
    }

    /**
     * @param string $mpeg4FileId
     *
     * @return InlineQueryResultCachedGif
     */
    public function setMpeg4FileId(string $mpeg4FileId): self
    {
        $this->mpeg4FileId = $mpeg4FileId;

        return $this;
    }

    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['mpeg4_file_id'] = $this->mpeg4FileId;

        if ($this->title !== null) {
            $result['title'] = $this->title;
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
