<?php

declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition;

use RuntimeException;

/**
 * @psalm-external-mutation-free
 */
class SectionDefinition
{
    public const array SECTION_MAP = [
        'Getting updates' => 'Update',
        #'Available types',
        #'Available methods',
        #'Updating messages',
        #'Stickers',
        'Inline mode' => 'InlineMode',
        #'Payments',
        #'Telegram Passport',
        #'Games',
    ];

    /**
     * @var list<TypeDefinition|MethodDefinition>
     */
    private array $items = [];

    /**
     * @psalm-mutation-free
     */
    public function __construct(
        private readonly string $title,
        public readonly BotApiDefinition $owner,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @psalm-external-mutation-free
     */
    public function addItem(TypeDefinition|MethodDefinition $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @psalm-mutation-free
     */
    public function getSectionId(): string
    {
        return self::SECTION_MAP[$this->title] ??
            throw new RuntimeException("Unknown section: {$this->title}");
    }
}
