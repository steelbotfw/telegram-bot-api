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
