<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Sticker
 */
class Sticker
{
    /**
     * Unique identifier for this file.
     *
     * @var string
     */
    public $fileId;

    public ?string $fileUniqueId;

    public ?string $type;

    /**
     * Sticker width.
     *
     * @var int
     */
    public $width;

    /**
     * Sticker height.
     *
     * @var int
     */
    public $height;

    public bool $isAnimated;

    public bool $isVideo;

    /**
     * Sticker thumbnail in .webp or .jpg format.
     *
     * @var PhotoSize
     */
    public $thumb;

    public ?PhotoSize $thumbnail;

    /**
     * @var string|null
     */
    public $emoji;

    public ?string $setName;

    public ?string $customEmojiId;

    /**
     * File size.
     *
     * @var int
     */
    public $fileSize;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fileId = $data['file_id'];
        $this->fileUniqueId = $data['file_unique_id'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->isAnimated = $data['is_animated'] ?? false;
        $this->isVideo = $data['is_video'] ?? false;
        $this->thumb = isset($data['thumb']) ? new PhotoSize($data['thumb']) : null;
        $this->thumbnail = isset($data['thumbnail']) ? new PhotoSize($data['thumbnail']) : $this->thumb;
        $this->emoji = $data['emoji'] ?? null;
        $this->setName = $data['set_name'] ?? null;
        $this->customEmojiId = $data['custom_emoji_id'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
