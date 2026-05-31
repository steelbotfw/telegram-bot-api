<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

readonly class ResolvedPhpType
{
    /**
     * @param list<class-string> $imports
     */
    public function __construct(
        public string $nativeType,
        public ?string $phpDocType = null,
        public array $imports = [],
    ) {
    }
}
