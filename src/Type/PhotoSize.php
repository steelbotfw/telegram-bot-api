<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * PhotoSize
 */
class PhotoSize
{
    /**
     * Unique identifier for this file.
     *
     * @var string
     */
    public $fileId;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     *
     * @var string|null
     */
    public $fileUniqueId;

    /**
     * Photo width.
     *
     * @var int
     */
    public $width;

    /**
     * Photo height.
     *
     * @var int
     */
    public $height;

    /**
     * File size.
     *
     * @var int|null
     */
    public $fileSize;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fileId = $data['file_id'];
        $this->fileUniqueId = $data['file_unique_id'] ?? null;
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->fileSize = $data['file_size'] ?? null;
    }

    /**
     * @param array $photoSizeArray
     *
     * @return PhotoSize[]|null
     */
    public static function createMultiple(?array $photoSizeArray): ?array
    {
        if (is_array($photoSizeArray)) {
            return array_map(function (array $photoSizeData) {
                return new self($photoSizeData);
            }, $photoSizeArray);
        }

        return null;
    }
}
