<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    CaptionTrait,
    DescriptionTrait,
    InputMessageContentTrait,
    JsonAttributesBuilderTrait,
    ReplyMarkupTrait,
    ThumbUrlOptionalTrait,
    ThumbWidthHeightOptionalTrait,
    TitleRequiredTrait
};

class InlineQueryResultDocument extends AbstractInlineQueryResult
{
    use TitleRequiredTrait;
    use CaptionTrait;
    use DescriptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;
    use ThumbUrlOptionalTrait;
    use ThumbWidthHeightOptionalTrait;

    use JsonAttributesBuilderTrait;

    /**
     * @var string
     */
    protected $type = 'document';

    /**
     * @var string
     */
    protected $documentUrl;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $title, string $documentUrl, string $mimeType)
    {
        parent::__construct($id);
        $this->title = $title;
        $this->documentUrl = $documentUrl;
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getDocumentUrl(): string
    {
        return $this->documentUrl;
    }

    /**
     * @param string $documentUrl
     *
     * @return InlineQueryResultDocument
     */
    public function setDocumentUrl(string $documentUrl): InlineQueryResultDocument
    {
        $this->documentUrl = $documentUrl;

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
     * @return InlineQueryResultDocument
     */
    public function setMimeType(string $mimeType): InlineQueryResultDocument
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();
        $result = array_merge($result, [
            'title' => $this->title,
            'document_url' => $this->documentUrl,
            'mime_type' => $this->mimeType,
        ]);

        $attributes = $this->buildJsonAttributes([
            'caption' => $this->caption,
            'description' => $this->description,
            'reply_markup' => $this->replyMarkup,
            'input_message_content' => $this->inputMessageContent,
            'thumb_url' => $this->thumbUrl,
            'thumb_width' => $this->thumbWidth,
            'thumb_height' => $this->thumbHeight
        ]);
        $result = array_merge($result, $attributes);

        return $result;
    }
}
