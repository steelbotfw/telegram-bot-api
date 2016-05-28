<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Document
 */
class Document
{
    /**
     * Unique identifier for this file.
     *
     * @var string
     */
    public $fileId;

    /**
     * Document thumbnail as defined by sender.
     *
     * @var PhotoSize[]|null
     */
    public $thumb;

    /**
     * Original filename as defined by sender.
     *
     * @var string|null
     */
    public $fileName;

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
        $this->thumb    = isset($data['thumb']) ? array_map(function(array $photoSizeData) {
            return new PhotoSize($photoSizeData);
        }, $data['thumb']) : null;
        $this->fileName = $data['file_name'] ?? null;
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
