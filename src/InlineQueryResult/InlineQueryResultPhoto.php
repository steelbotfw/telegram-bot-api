<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    DescriptionTrait,
    DisableWebPagePreviewTrait,
    ParseModeTrait,
    HideUrlTrait
};

class InlineQueryResultPhoto implements \JsonSerializable
{
    use ParseModeTrait;
    use DisableWebPagePreviewTrait;
    use HideUrlTrait;
    use DescriptionTrait;

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
    protected $photoUrl;

    /**
     * @var string
     */
    protected $thumbUrl;

    /**
     * @var string|null
     */
    protected $messageText;

    /**
     * @param array $data
     */
    public function __construct($id, string $photoUrl, string $thumbUrl)
    {
        $this->id = $id ? $id : uniqid('steelbot', true);
        $this->photoUrl = $photoUrl;
        $this->thumbUrl = $thumbUrl;
    }

    /**
     * @param string|null $text
     */
    public function setMessageText(string $text = null)
    {
        $this->messageText = $text;
    }

    /**
     * @return string|null
     */
    public function getMessageText()
    {
        return $this->messageText;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        $result = [
            'type' => $this->type,
            'id' => $this->id,
            'photo_url' => $this->photoUrl,
            'thumb_url' => $this->thumbUrl
        ];

        if ($this->messageText !== null) {
            $result['message_text'] = $this->messageText;
        }

        if ($this->parseMode) {
            $result['parse_mode'] = $this->parseMode;
        }

        if ($this->disableWebPagePreview) {
            $result['disable_web_page_preview'] = (int)$this->disableWebPagePreview;
        }

        if ($this->description) {
            $result['description'] = $this->description;
        }

        return $result;
    }
}
