<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

/**
 * @psalm-immutable
 */
readonly class ParameterDefinition
{
    /**
     * @psalm-mutation-free
     */
    public function __construct(
        public string $name,
        public ParameterTypeDefinition $typeDefinition,
        public string $description,
        public bool $isOptional,
        public TypeDefinition|MethodDefinition $owner,
    ) {
    }

}
