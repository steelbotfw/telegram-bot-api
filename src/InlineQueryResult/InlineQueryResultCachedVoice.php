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

class InlineQueryResultCachedVoice extends AbstractInlineQueryResult
{
    use TitleTrait;
    use CaptionTrait;
    use ReplyToMessageIdTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'voice';

    /**
     * @var string
     */
    protected $voiceFileId;

    public function __construct($id, string $voiceFileId)
    {
        parent::__construct($id);
        $this->voiceFileId = $voiceFileId;
    }

    /**
     * @return string
     */
    public function getVoiceFileId(): string
    {
        return $this->voiceFileId;
    }

    /**
     * @param string $voiceFileId
     *
     * @return InlineQueryResultCachedVoice
     */
    public function setVoiceFileId(string $voiceFileId): self
    {
        $this->voiceFileId = $voiceFileId;

        return $this;
    }

    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['voice_file_id'] = $this->voiceFileId;

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
