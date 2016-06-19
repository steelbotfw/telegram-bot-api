<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait, DescriptionTrait, DisableWebPagePreviewTrait, InputMessageContentTrait, ParseModeTrait, HideUrlTrait, ReplyMarkupTrait, TitleTrait
};

class InlineQueryResultCachedPhoto extends AbstractInlineQueryResult
{
    use TitleTrait;
    use DescriptionTrait;
    use CaptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'photo';

    /**
     * @var string
     */
    protected $photoFileId;

    /**
     * @param array $data
     */
    public function __construct($id, string $photoFileId)
    {
        parent::__construct($id);
        $this->photoFileId = $photoFileId;
    }

    /**
     * @return string
     */
    public function getPhotoFileId(): string
    {
        return $this->photoFileId;
    }

    /**
     * @param string $photoFileId
     *
     * @return InlineQueryResultCachedPhoto
     */
    public function setPhotoFileId(string $photoFileId)
    {
        $this->photoFileId = $photoFileId;

        return $this;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['photo_file_id'] = $this->photoFileId;

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
