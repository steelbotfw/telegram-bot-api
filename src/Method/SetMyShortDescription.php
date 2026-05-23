<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Method;

use JsonSerializable;

/**
 * @extends AbstractMethod<bool>
 */
final class SetMyShortDescription extends AbstractMethod implements JsonSerializable
{
    public function __construct(
        private readonly string $shortDescription,
    ) {
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getMethodName(): string
    {
        return 'setMyShortDescription';
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
     * @return array{short_description: string}
     */
    public function jsonSerialize(): array
    {
        return ['short_description' => $this->shortDescription];
    }
}
