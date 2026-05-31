<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class SectionDefinition
{
    /**
     * @var list<TypeDefinition|MethodDefinition>
     */
    private array $items = [];

    public function __construct(
        private readonly string $title,
        public readonly BotApiDefinition $owner,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function addItem(TypeDefinition|MethodDefinition $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}