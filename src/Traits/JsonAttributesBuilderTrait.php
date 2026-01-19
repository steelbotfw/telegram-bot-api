<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Traits;

trait JsonAttributesBuilderTrait
{
    /**
     * @param array $map
     *
     * @return array
     */
    protected function buildJsonAttributes(array $map): array
    {
        return array_filter($map, static fn (mixed $value) => $value !== null);
    }
}
