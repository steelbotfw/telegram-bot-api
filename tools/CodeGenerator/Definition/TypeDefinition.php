<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class TypeDefinition
{
    /**
     * @var TypeFieldDefinition[]
     */
    private array $fields = [];

    public function __construct(
        public readonly string $name,
        public readonly string $id,
    ) {
    }

    public function addField(TypeFieldDefinition $typeFieldDefinition): void
    {
        $this->fields[] = $typeFieldDefinition;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

}
