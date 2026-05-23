<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;

/**
 * @extends AbstractMethod<bool>
 */
final class SetMyName extends AbstractMethod implements JsonSerializable
{
    public function __construct(
        private readonly string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethodName(): string
    {
        return 'setMyName';
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getParams(): array
    {
        return [];
    }

    /**
     * @param bool $result
     */
    public function buildResult($result): bool
    {
        return $result;
    }

    /**
     * @return array{name: string}
     */
    public function jsonSerialize(): array
    {
        return ['name' => $this->name];
    }
}
