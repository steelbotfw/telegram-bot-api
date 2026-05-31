<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

/**
 * @psalm-external-mutation-free
 */
class ParameterTypeDefinition
{
    /**
     * Telegram parameter type alternatives parsed from an "or" definition.
     *
     * Examples:
     * - Integer: scalar type.
     * - #photosize: reference to a Telegram type definition.
     * - #photosize[]: array of PhotoSize.
     * - #photosize[][]: array of array of PhotoSize.
     *
     * @var string[]
     */
    private array $types = [];

    /**
     * @psalm-external-mutation-free
     */
    public function addType(string $type, bool $isArray): void
    {
        $this->types[] = trim($type) . ($isArray ? '[]' : '');
    }

    public function getTypes(): array
    {
        return $this->types;
    }
}
