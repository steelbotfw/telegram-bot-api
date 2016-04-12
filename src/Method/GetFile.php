<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\File;

class GetFile extends AbstractMethod
{
    /**
     * @var string
     */
    protected $fileId;

    public function __construct(string $fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     */
    public function setFileId(string $fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'getFile';
    }

    /**
     * HTTP method
     *
     * @return string
     */
    public function getHttpMethod(): string
    {
        return self::HTTP_GET;
    }

    /**
     * Get parameters for HTTP query.
     *
     * @return mixed
     */
    public function getParams(): array
    {
        return [
            'file_id' => $this->fileId
        ];
    }

    /**
     * Build result type from array of data.
     *
     * @param array $result
     *
     * @return object
     */
    public function buildResult($result): File
    {
        $file = new File($result);

        return $file;
    }
}
