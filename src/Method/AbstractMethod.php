<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

/**
 * @template T of object|bool|int
 */
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
     * @param array|bool $result
     *
     * @return T|T[]|bool
     */
    abstract public function buildResult($result): object|array|bool|int;
}
