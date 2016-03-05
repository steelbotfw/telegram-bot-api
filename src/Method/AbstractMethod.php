<?php

namespace Steelbot\TelegramBotApi\Method;

abstract class AbstractMethod
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
     * HTTP method
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
     * @param array|bool $result
     *
     * @return object
     */
    abstract public function buildResult($result);
}
