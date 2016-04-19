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

    /**
     * Sticker thumbnail in .webp or .jpg format.
     *
     * @var PhotoSize
     */
    public $thumb;

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
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->thumb = isset($data['thumb']) ? new PhotoSize($data['thumb']) : null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
