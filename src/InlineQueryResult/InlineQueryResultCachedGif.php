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

class InlineQueryResultCachedGif extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use ReplyToMessageIdTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'gif';

    /**
     * @var string
     */
    protected $gifFileId;

    public function __construct($id, string $gifFileId)
    {
        parent::__construct($id);
        $this->gifFileId = $gifFileId;
    }

    /**
     * @return string
     */
    public function getGifFileId(): string
    {
        return $this->gifFileId;
    }

    /**
     * @param string $gifFileId
     *
     * @return InlineQueryResultCachedGif
     */
    public function setGifFileId(string $gifFileId): self
    {
        $this->gifFileId = $gifFileId;

        return $this;
    }

    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['gif_file_id'] = $this->gifFileId;

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
