<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    DescriptionTrait, DisableWebPagePreviewTrait, InputMessageContentTrait, ParseModeTrait, HideUrlTrait, ReplyMarkupTrait
};

class InlineQueryResultCachedPhoto implements \JsonSerializable
{
    use DescriptionTrait;
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'photo';

    /**
     * @var
     */
    protected $id;

    /**
     * @var string
     */
    protected $photoFileId;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $caption;

    /**
     * @param array $data
     */
    public function __construct($id, string $photoFileId)
    {
        $this->id = $id ? $id : uniqid('steelbot', true);
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
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return InlineQueryResultCachedPhoto
     */
    public function setTitle(string $title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param null|string $caption
     *
     * @return InlineQueryResultCachedPhoto
     */
    public function setCaption(string $caption = null)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = [
            'type' => $this->type,
            'id' => $this->id,
            'photo_file_id' => $this->photoFileId
        ];

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
