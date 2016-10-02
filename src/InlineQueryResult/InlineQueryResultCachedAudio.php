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

class InlineQueryResultCachedAudio extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use ReplyToMessageIdTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'audio';

    /**
     * @var string
     */
    protected $audioFileId;

    public function __construct($id, string $audioFileId)
    {
        parent::__construct($id);
        $this->audioFileId = $audioFileId;
    }

    /**
     * @return string
     */
    public function getAudioFileId(): string
    {
        return $this->audioFileId;
    }

    /**
     * @param string $audioFileId
     *
     * @return InlineQueryResultCachedAudio
     */
    public function setAudioFileId(string $audioFileId): self
    {
        $this->audioFileId = $audioFileId;

        return $this;
    }

    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['audio_file_id'] = $this->audioFileId;

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
