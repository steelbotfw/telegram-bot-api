<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

readonly class TypeFieldDefinition
{
    public function __construct(
        public string $name,
        public ValueTypeDefinition $valueTypeDefinition,
        public string $description,
        public bool $isOptional,
    ) {
    }

}