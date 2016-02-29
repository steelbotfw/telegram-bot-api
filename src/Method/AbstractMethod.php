<?php

namespace Steelbot\TelegramBotApi\Method;

abstract class AbstractMethod implements \JsonSerializable
{
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';

    /**
     * Get method name.
     *
     * @return string
     */
    abstract public function getMethodName(): string;

    /**
     * GET or POST
     *
     * @return string
     */
    abstract public function getHttpMethod(): string;

    /**
     * Get parameters for HTTP query.
     *
     * @return mixed
     */
    abstract public function getParams(): array;

    /**
     * Build result type from array of data.
     *
     * @param array $result
     *
     * @return object
     */
    abstract public function buildResult(array $result);
}
