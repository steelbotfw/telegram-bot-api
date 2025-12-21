<?php

namespace Steelbot\TelegramBotApi\InlineQueryResult;

use Steelbot\TelegramBotApi\Traits\{
    DescriptionTrait, DisableWebPagePreviewTrait, InputMessageContentTrait, ParseModeTrait, HideUrlTrait, ReplyMarkupTrait
};
use Override;

class InlineQueryResultCachedSticker implements \JsonSerializable
{
    use ReplyMarkupTrait;
    use InputMessageContentTrait;

    /**
     * @var string
     */
    protected $type = 'sticker';

    /**
     * @var
     */
    protected $id;

    /**
     * @var string
     */
    protected $stickerFileId;

    /**
     * @param array $data
     */
    public function __construct($id = null, string $stickerFileId)
    {
        $this->id = $id ? $id : uniqid('steelbot', true);
        $this->stickerFileId = $stickerFileId;
    }

    /**
     * @return string
     */
    public function getStickerFileId(): string
    {
        return $this->stickerFileId;
    }

    /**
     * @param string $stickerFileId
     *
     * @return InlineQueryResultCachedSticker
     */
    public function setStickerFileId(string $stickerFileId)
    {
        $this->stickerFileId = $stickerFileId;

        return $this;
    }

    #[Override]
    public function jsonSerialize(): array
    {
        $result = [
            'type' => $this->type,
            'id' => $this->id,
            'sticker_file_id' => $this->stickerFileId,
        ];

        if ($this->replyMarkup) {
            $result['reply_markup'] = $this->replyMarkup;
        }

        if ($this->inputMessageContent !== null) {
            $result['input_message_content'] = $this->inputMessageContent;
        }

        return $result;
    }
}
