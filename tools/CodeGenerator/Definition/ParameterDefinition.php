<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

readonly class ParameterDefinition
{
    public function __construct(
        public string $name,
        public ParameterTypeDefinition $typeDefinition,
        public string $description,
        public bool $isOptional,
        public TypeDefinition|MethodDefinition $owner,
    ) {
    }

}