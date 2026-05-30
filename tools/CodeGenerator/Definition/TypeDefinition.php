<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class TypeDefinition
{
    /**
     * @var ParameterDefinition[]
     */
    private array $fields = [];

    public function __construct(
        public readonly string $name,
        public readonly string $id,
        public readonly SectionDefinition $owner,
    ) {
    }

    public function addField(ParameterDefinition $typeFieldDefinition): void
    {
        $this->fields[] = $typeFieldDefinition;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

}
