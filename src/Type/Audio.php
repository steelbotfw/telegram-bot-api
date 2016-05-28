<?php

namespace Steelbot\TelegramBotApi\Type;

/**
 * Audio
 */
class Audio
{
    /**
     * Unique identifier for this file.
     *
     * @var string
     */
    public $fileId;

    /**
     * Duration of the audio in seconds as defined by sender.
     *
     * @var int
     */
    public $duration;

    /**
     * Performer of the audio as defined by sender or by audio tags.
     *
     * @var string|null
     */
    public $performer;

    /**
     * Title of the audio as defined by sender or by audio tags.
     *
     * @var string|null
     */
    public $title;

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
        $this->performer = $data['performer'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->mimeType = $data['mime_type'] ?? null;
        $this->fileSize = $data['file_size'] ?? null;
    }
}
