<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * File
 */
class File
{
    /**
     * @var string
     */
    public $fileId;

    /**
     * @var integer|null
     */
    public $fileSize;

    /**
     * @var string|null
     */
    public $filePath;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fileId = $data['file_id'];
        $this->fileSize = $data['file_size'] ?? null;
        $this->filePath = $data['file_path'] ?? null;
    }
}
