<?php

namespace Steelbot\TelegramBotApi\Method;

use Steelbot\TelegramBotApi\Type\Update;

class GetUpdates extends AbstractMethod
{
    /**
     * @var int
     */
    protected $offset;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $timeout;

    protected $lastUpdateId = 0;

    public function __construct(int $offset, int $limit = 5, int $timeout = 30)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     *
     * @return GetUpdates
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     *
     * @return GetUpdates
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return GetUpdates
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'getUpdates';
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
            'offset' => $this->offset,
            'limit' => $this->limit,
            'timeout' => $this->timeout
        ];
    }

    /**
     * Build result type from array of data.
     *
     * @param array $result
     *
     * @return object
     */
    public function buildResult($result)
    {
        $updates = [];

        foreach ($result as $updateData) {
            $update = new Update($updateData);
            $updates[] = $update;
            $this->lastUpdateId = max($this->lastUpdateId, $update->updateId);
        }

        return $updates;
    }

    /**
     * @return int
     */
    public function getLastUpdateId(): int
    {
        return $this->lastUpdateId;
    }
}
