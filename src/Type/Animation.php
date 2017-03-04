<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Animation
 */
class Animation
{
    /**
     * @var string
     */
    public $fileId;

    /**
     * @var PhotoSize|null
     */
    public $thumb;

    /**
     * @var string|null
     */
    public $fileName;

    /**
     * @var string|null
     */
    public $mimeType;

    /**
     * @var int|null
     */
    public $fileSize;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fileId = $data['file_id'];
        $this->thumb = $data['thumb'] ?? new PhotoSize($data['thumb']);
        $this->fileName = $data['file_name'] ?? null;
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
