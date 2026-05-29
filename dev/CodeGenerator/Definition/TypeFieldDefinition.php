<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApiDev\CodeGenerator\Definition;

class TypeFieldDefinition
{
    private bool $isOptional;

    public function __construct(
        private string $field,
        private string $type,
        private array $description,
    ) {

    }
}