<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class TypeDefinition
{
    private array $fields;

    public function __construct(
        public readonly string $id,
    ) {
    }

    public function addField(TypeFieldDefinition $typeFieldDefinition): void
    {
        $this->fields[] = $typeFieldDefinition;
    }


}