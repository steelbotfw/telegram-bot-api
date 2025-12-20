<?php

declare(strict_types=1);

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

    abstract public function getHttpMethod(): HttpMethod;

    /**
     * Get parameters for HTTP query.
     */
    abstract public function getParams(): array;

    /**
     * Build result type from an array of data.
     *
     * @param array|bool $result
     *
     * @return object
     */
    abstract public function buildResult($result);
}
