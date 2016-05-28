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
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->duration = $data['duration'];
        $this->thumb    = isset($data['thumb']) ? array_map(function(array $photoSizeData) {
            return new PhotoSize($photoSizeData);
        }, $data['thumb']) : null;
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
