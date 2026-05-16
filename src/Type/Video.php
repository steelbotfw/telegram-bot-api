<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Video
 */
class Video
{
    /**
     * Unique identifier for this file.
     *
     * @var string
     */
    public $fileId;

    public ?string $fileUniqueId;

    /**
     * Video width as defined by sender.
     *
     * @var int
     */
    public $width;

    /**
     * Video height as defined by sender.
     *
     * @var int
     */
    public $height;

    /**
     * Duration of the video in seconds as defined by sender.
     *
     * @var int
     */
    public $duration;

    /**
     * Video thumbnail as defined by sender.
     *
     * @var PhotoSize[]|null
     */
    public $thumb;

    public ?PhotoSize $thumbnail;

    /**
     * MIME type of the file as defined by sender.
     *
     * @var string|null
     */
    public $mimeType;

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
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->duration = $data['duration'];
        $this->thumb = $this->parseThumb($data['thumb'] ?? null);
        $this->thumbnail = isset($data['thumbnail']) ? new PhotoSize($data['thumbnail']) : ($this->thumb[0] ?? null);
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }

    /**
     * @return PhotoSize[]|null
     */
    private function parseThumb($thumb): ?array
    {
        if ($thumb === null) {
            return null;
        }

        if (isset($thumb['file_id'])) {
            return [new PhotoSize($thumb)];
        }

        if (is_array($thumb)) {
            return array_map(function (array $photoSizeData) {
                return new PhotoSize($photoSizeData);
            }, $thumb);
        }

        return null;
    }
}
