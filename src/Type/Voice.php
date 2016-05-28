<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Voice
 */
class Voice
{
    /**
     * Unique identifier for this file.
     *
     * @var string
     */
    public $fileId;

    /**
     * Duration of the Voice in seconds as defined by sender.
     *
     * @var int
     */
    public $duration;

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
        $this->duration = $data['duration'];
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
