<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait, DescriptionTrait, DisableWebPagePreviewTrait, InputMessageContentTrait, ParseModeTrait, HideUrlTrait, ReplyMarkupTrait, TitleTrait
};

class InlineQueryResultCachedDocument extends AbstractInlineQueryResult
{
    use TitleTrait;
    use DescriptionTrait;
    use CaptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'document';

    /**
     * @var string
     */
    protected $documentFileId;

    /**
     * @param array $data
     */
    public function __construct($id, string $documentFileId)
    {
        parent::__construct($id);
        $this->documentFileId = $documentFileId;
    }

    /**
     * @return string
     */
    public function getDocumentFileId(): string
    {
        return $this->documentFileId;
    }

    /**
     * @param string $documentFileId
     *
     * @return InlineQueryResultCachedDocument
     */
    public function setDocumentFileId(string $documentFileId)
    {
        $this->documentFileId = $documentFileId;

        return $this;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result['document_file_id'] = $this->documentFileId;

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
