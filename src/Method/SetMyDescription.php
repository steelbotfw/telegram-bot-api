<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;

/**
 * @extends AbstractMethod<bool>
 */
final class SetMyDescription extends AbstractMethod implements JsonSerializable
{
    public function __construct(
        private readonly string $description,
    ) {
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMethodName(): string
    {
        return 'setMyDescription';
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
     * @return array{description: string}
     */
    public function jsonSerialize(): array
    {
        return ['description' => $this->description];
    }
}
