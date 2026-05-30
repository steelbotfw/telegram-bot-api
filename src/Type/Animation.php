<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Animation: GIF or H.264/MPEG-4 AVC video without sound.
 */
class Animation
{
    public string $fileId;

    public ?string $fileUniqueId;

    public int $width;

    public int $height;

    public int $duration;

    public ?PhotoSize $thumbnail;

    public ?string $fileName;

    public ?string $mimeType;

    public ?int $fileSize;

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
        $this->thumbnail = isset($data['thumbnail']) ? new PhotoSize($data['thumbnail']) : null;
        $this->fileName = $data['file_name'] ?? null;
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
