<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

/**
 * @psalm-immutable
 */
readonly class ResolvedPhpType
{
    /**
     * @param list<string> $nativeTypes
     * @param list<class-string> $imports
     *
     * @psalm-mutation-free
     */
    public function __construct(
        public array $nativeTypes,
        public ?string $phpDocType = null,
        public array $imports = [],
        public ?string $rawPhpDocType = null,
    ) {
    }
}
