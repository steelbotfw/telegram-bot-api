<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class ValueTypeDefinition
{
    /**
     * @var string[]
     */
    private array $types = [];

    public function addType(string $type, bool $isArray): void
    {
        $this->types[] = trim($type) . ($isArray ? '[]' : '');
    }

    public function getTypes(): array
    {
        return $this->types;
    }
}
