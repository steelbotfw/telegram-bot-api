<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

/**
 * @psalm-immutable
 */
class MethodDefinition
{
    /**
     * @psalm-mutation-free
     */
    public function __construct(
        public readonly string $name,
        public readonly string $id,
        public readonly SectionDefinition $owner,
    ) {
    }
}
