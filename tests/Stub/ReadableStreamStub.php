<?php

namespace Steelbot\Tests\TelegramBotApi\Stub;

use Icicle\Stream\ReadableStream;

class ReadableStreamStub implements ReadableStream
{
    /**
     * @var string
     */
    private $data;

    private $isReadable = true;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function read(int $length = 0, string $byte = null, float $timeout = 0): \Generator
    {
        $this->isReadable = false;

        return yield $this->data;
    }

    public function isReadable(): bool
    {
        return $this->isReadable;
    }

    /**
     * Determines if the stream is still open.
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isReadable;
    }

    /**
     * Closes the stream, making it unreadable or unwritable.
     */
    public function close()
    {
        $this->isReadable = false;
    }
}
