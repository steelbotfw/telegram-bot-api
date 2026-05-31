<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

class BotApiDefinition
{
    /**
     * @var SectionDefinition[]
     */
    private array $sections = [];

    /**
     * @var array<string, TypeDefinition|MethodDefinition>
     */
    private array $itemMap = [];

    public function addSection(SectionDefinition $section): void
    {
        $this->sections[] = $section;

        foreach ($section->getItems() as $item) {
            if (isset($this->itemMap[$item->id])) {
                throw new \LogicException("Item {$item->id} is already defined");
            }

            $this->itemMap[$item->id] = $item;
        }
    }

    public function getSections(): array
    {
        return $this->sections;
    }

    public function getItem(string $id): TypeDefinition|MethodDefinition
    {
        return $this->itemMap[$id];
    }

    public function hasItem(string $id): bool
    {
        return isset($this->itemMap[$id]);
    }
}
